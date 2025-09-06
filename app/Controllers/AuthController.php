<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

/**
 * Controleur AuthController pour la gestion complete de l'authentification et du profil utilisateur
 * - Gere l'inscription, connexion et deconnexion des utilisateurs
 * - Permet la gestion du profil utilisateur avec informations personnelles
 * - Gere les adresses multiples avec systeme d'adresse par defaut
 * - Controle la securite des mots de passe et des sessions
 * - Permet la modification des informations et la suppression de compte
 */
class AuthController extends BaseController
{
    /**
     * Affichage du formulaire d'inscription
     * - Affiche le formulaire vide pour la creation d'un nouveau compte
     * - Prepare l'interface pour la saisie des informations personnelles
     * - Permet l'inscription avec validation des donnees
     */
    public function inscription()
    {
        return view('VueInscription');
    }

    /**
     * Traitement de l'inscription d'un nouvel utilisateur
     * - Valide les donnees du formulaire (email unique, mot de passe, confirmation)
     * - Verifie la longueur minimale du mot de passe (9 caracteres)
     * - Cree l'utilisateur en base avec role 'client' par defaut
     * - Cree automatiquement une adresse par defaut avec les informations saisies
     * - Applique le hachage securise du mot de passe via UserModel
     * - Redirige vers la page de connexion avec message de succes
     */
    public function traitementInscription()
    {
        $nom = $this->request->getPost('nom');
        $prenom = $this->request->getPost('prenom');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm-password');

        if ($password !== $confirmPassword) {
            return redirect()->back()->withInput()->with('error', 'Les mots de passe ne correspondent pas.');
        }

        // Validation de la longueur du mot de passe
        if (strlen($password) < 9) {
            return redirect()->back()->withInput()->with('error', 'Le mot de passe doit contenir au minimum 9 caractères.');
        }

        $userModel = new UserModel();

        // Vérifie si l'e-mail existe déjà
        if ($userModel->where('email', $email)->first()) {
            return redirect()->back()->withInput()->with('error', 'Cet e-mail est déjà utilisé.');
        }

        $data = [
            'nomcompte' => $nom,
            'prenomcompte' => $prenom,
            'email' => $email,
            'password' => $password,
            'role' => 'client',
            'nom' => $nom,
            'prenom' => $prenom,
            'telephone' => $this->request->getPost('telephone'),
            'adresse' => $this->request->getPost('adresse'),
            'complement' => $this->request->getPost('complement'),
            'code_postal' => $this->request->getPost('code_postal'),
            'ville' => $this->request->getPost('ville'),
            'departement' => $this->request->getPost('departement'),
            'pays' => $this->request->getPost('pays'),
        ];

        // Sauvegarder l'utilisateur et récupérer son ID
        $userId = $userModel->insert($data);

        // Créer automatiquement une adresse par défaut
        $adresseModel = new \App\Models\AdresseModel();
        $adresseData = [
            'user_id' => $userId,
            'nom' => $nom,
            'prenom' => $prenom,
            'titre' => 'Adresse par défaut',
            'adresse' => $this->request->getPost('adresse'),
            'complement' => $this->request->getPost('complement'),
            'code_postal' => $this->request->getPost('code_postal'),
            'ville' => $this->request->getPost('ville'),
            'departement' => $this->request->getPost('departement'),
            'pays' => $this->request->getPost('pays'),
            'telephone' => $this->request->getPost('telephone'),
            'is_defaut' => 1 // Marquer comme adresse par défaut
        ];

        $adresseModel->insert($adresseData);

        return redirect()->to('/connexion')->with('success', 'Inscription réussie. Vous pouvez maintenant vous connecter.');
    }

    /**
     * Affichage du formulaire de connexion
     * - Affiche le formulaire de connexion avec email et mot de passe
     * - Permet l'authentification des utilisateurs existants
     */
    public function connexion()
    {
        return view('VueConnexion');
    }

    /**
     * Traitement de la connexion utilisateur
     * - Verifie les identifiants (email et mot de passe)
     * - Applique la verification securisee du mot de passe avec password_verify()
     * - Cree la session utilisateur avec toutes les informations necessaires
     * - Redirige selon le role (admin vers tableau de bord, client vers accueil)
     * - Gere les erreurs d'authentification avec messages explicites
     */
    public function traitementConnexion()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set([
                'user_id' => $user['id'],
                'email' => $user['email'],
                'nom' => $user['nom'],
                'role' => $user['role'],
                'isLoggedIn' => true
            ]);

            // Rediriger selon le rôle
            if ($user['role'] === 'admin') {
                return redirect()->to('/')->with('success', 'Bienvenue, administrateur.');
            } else {
                return redirect()->to('/')->with('success', 'Bienvenue sur Trufficat !');
            }
        }

        return redirect()->back()->withInput()->with('error', 'Identifiants invalides.');
    }

    /**
     * Deconnexion de l'utilisateur
     * - Detruit completement la session utilisateur
     * - Supprime toutes les donnees de session
     * - Redirige vers l'accueil avec message de confirmation
     */
    public function deconnexion()
    {
        session()->destroy();
        return redirect()->to('/')->with('success', 'Déconnexion réussie.');
    }

    /**
     * Affichage du profil utilisateur avec gestion des adresses
     * - Recupere les informations utilisateur depuis la session
     * - Recupere toutes les adresses de l'utilisateur
     * - Separe l'adresse par defaut des adresses supplementaires
     * - Affiche le profil avec toutes les informations organisees
     * - Permet la gestion des adresses multiples
     */
    public function profil()
    {
        $userModel = new \App\Models\UserModel();
        $adresseModel = new \App\Models\AdresseModel();

        $userId = session()->get('user_id');
        $user = $userModel->find($userId);

        // Récupérer toutes les adresses de l'utilisateur
        $adresses = $adresseModel->where('user_id', $userId)->findAll();

        // Séparer l'adresse par défaut des autres
        $adresseDefaut = null;
        $adressesSupplementaires = [];

        foreach ($adresses as $adresse) {
            if ($adresse['is_defaut'] == 1) {
                $adresseDefaut = $adresse;
            } else {
                // Plus de comptage des commandes liées - les adresses supplémentaires sont librement supprimables
                $adressesSupplementaires[] = $adresse;
            }
        }

        return view('VueProfil', [
            'user' => $user,
            'adresseDefaut' => $adresseDefaut,
            'adressesSupplementaires' => $adressesSupplementaires
        ]);
    }

    /**
     * Affichage du formulaire d'ajout d'adresse supplementaire
     * - Affiche le formulaire vide pour creer une nouvelle adresse
     * - Permet l'ajout d'adresses supplementaires au profil
     * - Les nouvelles adresses ne sont jamais definies comme adresse par defaut
     */
    public function ajouterAdresse()
    {
        return view('AdresseAjouter');
    }

    /**
     * Traitement de l'ajout d'une adresse supplementaire
     * - Recupere et valide les donnees du formulaire d'adresse
     * - Cree une nouvelle adresse avec is_defaut = 0 (supplementaire)
     * - Associe l'adresse a l'utilisateur connecte via user_id
     * - Redirige vers le profil avec message de confirmation
     */
    public function saveAdresse()
    {
        $adresseModel = new \App\Models\AdresseModel();
        $userId = session()->get('user_id');

        $data = [
            'user_id' => $userId,
            'nom' => $this->request->getPost('nom'),
            'prenom' => $this->request->getPost('prenom'),
            'adresse' => $this->request->getPost('adresse'),
            'complement' => $this->request->getPost('complement'),
            'code_postal' => $this->request->getPost('code_postal'),
            'ville' => $this->request->getPost('ville'),
            'departement' => $this->request->getPost('departement'),
            'pays' => $this->request->getPost('pays'),
            'telephone' => $this->request->getPost('telephone'),
            'is_defaut' => 0, // Les nouvelles adresses ne sont jamais par défaut
        ];

        $adresseModel->save($data);
        return redirect()->to('/profil')->with('success', 'Adresse supplémentaire ajoutée.');
    }

    /**
     * Affichage du formulaire de modification d'une adresse
     * - Verifie que l'adresse appartient bien a l'utilisateur connecte
     * - Affiche le formulaire pre-rempli avec les donnees actuelles
     * - Permet la modification de tous les champs de l'adresse
     * - Controle la securite pour eviter la modification d'adresses d'autres utilisateurs
     */
    public function modifierAdresse($id)
    {
        $adresseModel = new \App\Models\AdresseModel();
        $adresse = $adresseModel->find($id);

        if (!$adresse || $adresse['user_id'] != session()->get('user_id')) {
            return redirect()->to('/profil')->withInput()->with('error', 'Adresse non trouvée.');
        }

        return view('AdresseModifier', ['adresse' => $adresse]);
    }

    /**
     * Traitement de la modification d'une adresse existante
     * - Met a jour tous les champs de l'adresse avec les nouvelles donnees
     * - Conserve l'ID de l'adresse et sa propriete (defaut ou supplementaire)
     * - Redirige vers le profil avec message de confirmation
     * - Permet la modification des adresses supplementaires et par defaut
     */
    public function updateAdresse($id)
    {
        $adresseModel = new \App\Models\AdresseModel();
        $userId = session()->get('user_id');

        $data = [
            'nom' => $this->request->getPost('nom'),
            'prenom' => $this->request->getPost('prenom'),
            'adresse' => $this->request->getPost('adresse'),
            'complement' => $this->request->getPost('complement'),
            'code_postal' => $this->request->getPost('code_postal'),
            'ville' => $this->request->getPost('ville'),
            'departement' => $this->request->getPost('departement'),
            'pays' => $this->request->getPost('pays'),
            'telephone' => $this->request->getPost('telephone'),
        ];

        $adresseModel->update($id, $data);
        return redirect()->to('/profil')->with('success', 'Adresse mise à jour.');
    }

    /**
     * Suppression d'une adresse supplementaire
     * - Verifie que l'adresse appartient a l'utilisateur connecte
     * - Supprime l'adresse de la base de donnees
     * - Permet la suppression libre des adresses supplementaires
     * - Redirige vers le profil avec message de confirmation
     */
    public function supprimerAdresse($id)
    {
        $adresseModel = new \App\Models\AdresseModel();
        $adresse = $adresseModel->find($id);

        if ($adresse && $adresse['user_id'] == session()->get('user_id')) {
            $adresseModel->delete($id);
            return redirect()->to('/profil')->with('success', 'Adresse supprimée.');
        }

        return redirect()->to('/profil')->with('error', 'Adresse non trouvée.');
    }

    /**
     * Affichage du formulaire de changement de mot de passe
     * - Affiche le formulaire avec ancien mot de passe et nouveau
     * - Permet la modification securisee du mot de passe
     * - Inclut la confirmation du nouveau mot de passe
     */
    public function changerMotDePasse()
    {
        return view('ChangerMotDePasse');
    }

    /**
     * Traitement du changement de mot de passe
     * - Verifie l'ancien mot de passe avec password_verify()
     * - Valide la correspondance entre nouveau mot de passe et confirmation
     * - Controle la longueur minimale du nouveau mot de passe (9 caracteres)
     * - Applique le hachage securise via UserModel
     * - Redirige vers le profil avec message de confirmation
     */
    public function traiterChangementMotDePasse()
    {
        $userModel = new \App\Models\UserModel();
        $userId = session()->get('user_id');
        $ancien = $this->request->getPost('ancien');
        $nouveau = $this->request->getPost('nouveau');
        $confirmer = $this->request->getPost('confirmer');

        $user = $userModel->find($userId);

        // Vérification du mot de passe actuel
        if (!password_verify($ancien, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Ancien mot de passe incorrect.');
        }
        if ($nouveau !== $confirmer) {
            return redirect()->back()->withInput()->with('error', 'Les mots de passe ne correspondent pas.');
        }

        // Validation de la longueur du nouveau mot de passe
        if (strlen($nouveau) < 9) {
            return redirect()->back()->withInput()->with('error', 'Le nouveau mot de passe doit contenir au minimum 9 caractères.');
        }

        // Le hash sera fait automatiquement par UserModel
        $userModel->update($userId, ['password' => $nouveau]);
        return redirect()->to('/profil')->with('success', 'Mot de passe changé.');
    }

    /**
     * Suppression du compte utilisateur
     * - Supprime completement l'utilisateur de la base de donnees
     * - Detruit la session utilisateur
     * - Redirige vers l'accueil avec message de confirmation
     * - Action irreversible qui supprime toutes les donnees utilisateur
     */
    public function supprimerCompte()
    {
        $userModel = new \App\Models\UserModel();
        $userId = session()->get('user_id');

        // Supprime l'utilisateur
        $userModel->delete($userId);

        // Détruit la session
        session()->destroy();

        return redirect()->to('/')->with('success', 'Votre compte a bien été supprimé.');
    }

    /**
     * Definition d'une adresse supplementaire comme adresse par defaut
     * - Recupere l'adresse a definir comme defaut
     * - Met a jour l'ancienne adresse par defaut (is_defaut = 0)
     * - Definit la nouvelle adresse comme defaut (is_defaut = 1)
     * - Assure qu'une seule adresse par defaut existe par utilisateur
     * - Redirige vers le profil avec message de confirmation
     */
    public function definirAdresseDefaut($id)
    {
        $adresseModel = new \App\Models\AdresseModel();
        $userId = session()->get('user_id');

        $nouvelleAdresseDefaut = $adresseModel->where('user_id', $userId)->find($id);
        if (!$nouvelleAdresseDefaut) {
            return redirect()->to('/profil')->with('error', 'Adresse non trouvée.');
        }

        // Récupérer l'ancienne adresse par défaut
        $ancienneAdresseDefaut = $adresseModel->where('user_id', $userId)->where('is_defaut', 1)->first();

        // Mettre l'ancienne adresse par défaut comme supplémentaire (is_defaut = 0)
        if ($ancienneAdresseDefaut) {
            $adresseModel->update($ancienneAdresseDefaut['id'], ['is_defaut' => 0]);
        }

        // Définir la nouvelle adresse comme défaut
        $adresseModel->update($id, ['is_defaut' => 1]);

        return redirect()->to('/profil')->with('success', 'Adresse par défaut modifiée.');
    }

    /**
     * Synchronisation d'une adresse supplementaire vers l'adresse principale
     * - Met a jour les informations de l'utilisateur avec celles de l'adresse
     * - Synchronise nom, prenom, adresse, telephone et autres champs
     * - Permet de recuperer les informations d'une adresse supplementaire
     * - Utilise pour la synchronisation des donnees entre adresses
     */
    public function adresseDevientPrincipale($adresseId)
    {
        $userModel = new \App\Models\UserModel();
        $adresseModel = new \App\Models\AdresseModel();

        $adresse = $adresseModel->find($adresseId);
        $userModel->update($adresse['user_id'], [
            'nom' => $adresse['nom'],
            'prenom' => $adresse['prenom'],
            'adresse' => $adresse['adresse'],
            'complement' => $adresse['complement'],
            'code_postal' => $adresse['code_postal'],
            'ville' => $adresse['ville'],
            'departement' => $adresse['departement'],
            'pays' => $adresse['pays'],
            'telephone' => $adresse['telephone'],
        ]);
    }

    /**
     * Remise de l'adresse principale comme adresse par defaut
     * - Met toutes les adresses supplementaires a is_defaut = 0
     * - Permet de revenir a l'adresse principale comme adresse par defaut
     * - Redirige vers le profil avec message de confirmation
     * - Utilise pour la gestion du systeme d'adresses multiples
     */
    public function definirPrincipaleDefaut()
    {
        $adresseModel = new \App\Models\AdresseModel();
        $userId = session()->get('user_id');

        // Met toutes les adresses secondaires à is_defaut=0
        $adresseModel->where('user_id', $userId)->set(['is_defaut' => 0])->update();

        return redirect()->to('/profil')->with('success', 'Adresse principale définie par défaut.');
    }

    /**
     * Affichage du formulaire de modification de l'adresse principale
     * - Recupere les informations de l'utilisateur depuis la base
     * - Transforme les donnees utilisateur en format adresse
     * - Affiche le formulaire avec le flag isDefaut = true
     * - Permet la modification de l'adresse principale du profil
     */
    public function afficherFormulaireAdressePrincipale()
    {
        $userModel = new \App\Models\UserModel();
        $userId = session()->get('user_id');
        $user = $userModel->find($userId);

        // On passe les champs de l'adresse principale sous forme de tableau $adresse
        $adresse = [
            'nom' => $user['nom'],
            'prenom' => $user['prenom'],
            'telephone' => $user['telephone'],
            'adresse' => $user['adresse'],
            'complement' => $user['complement'],
            'code_postal' => $user['code_postal'],
            'ville' => $user['ville'],
            'departement' => $user['departement'],
            'pays' => $user['pays'],
        ];

        return view('AdresseModifier', [
            'adresse' => $adresse,
            'isDefaut' => true
        ]);
    }

    /**
     * Traitement de la modification des informations de compte
     * - Met a jour nomcompte, prenomcompte, email et telephone
     * - Conserve les autres informations du profil
     * - Redirige vers le profil avec message de confirmation
     * - Permet la modification des informations de base du compte
     */
    public function modifierInfos()
    {
        $userModel = new \App\Models\UserModel();
        $userId = session()->get('user_id');
        $data = [
            'nomcompte' => $this->request->getPost('nom'),
            'prenomcompte' => $this->request->getPost('prenom'),
            'email' => $this->request->getPost('email'),
            'telephone' => $this->request->getPost('telephone'),
        ];
        $userModel->update($userId, $data);
        return redirect()->to('/profil')->with('success', 'Informations modifiées.');
    }

    /**
     * Traitement de la mise a jour des informations personnelles
     * - Met a jour uniquement nom et prenom dans les champs personnels
     * - Distingue les informations de compte (nomcompte) des informations personnelles (nom)
     * - Redirige vers le profil avec message de confirmation
     * - Permet la synchronisation des donnees personnelles
     */
    public function updateInfos()
    {
        $userModel = new \App\Models\UserModel();
        $userId = session()->get('user_id');
        $data = [
            'nom' => $this->request->getPost('nom'),
            'prenom' => $this->request->getPost('prenom'),
        ];
        $userModel->update($userId, $data);
        return redirect()->to('/profil')->with('success', 'Informations modifiées.');
    }

    /**
     * Affichage du formulaire de modification des informations
     * - Recupere les informations actuelles de l'utilisateur
     * - Affiche le formulaire pre-rempli avec les donnees existantes
     * - Permet la modification des informations personnelles
     */
    public function afficherFormulaireInfos()
    {
        $userModel = new \App\Models\UserModel();
        $userId = session()->get('user_id');
        $user = $userModel->find($userId);
        return view('InfosModifier', ['user' => $user]);
    }

    /**
     * Traitement de la modification de l'adresse principale
     * - Met a jour tous les champs d'adresse de l'utilisateur
     * - Synchronise les informations avec l'adresse principale
     * - Redirige vers le profil avec message de confirmation
     * - Permet la modification de l'adresse principale du profil
     */
    public function modifierAdressePrincipale()
    {
        $userModel = new \App\Models\UserModel();
        $userId = session()->get('user_id');
        $data = [
            'nom' => $this->request->getPost('nom'),
            'prenom' => $this->request->getPost('prenom'),
            'adresse' => $this->request->getPost('adresse'),
            'complement' => $this->request->getPost('complement'),
            'code_postal' => $this->request->getPost('code_postal'),
            'ville' => $this->request->getPost('ville'),
            'departement' => $this->request->getPost('departement'),
            'pays' => $this->request->getPost('pays'),
            'telephone' => $this->request->getPost('telephone'),
        ];
        $userModel->update($userId, $data);
        return redirect()->to('/profil')->with('success', 'Adresse principale modifiée.');
    }

    /**
     * Affichage du formulaire de modification de l'adresse par defaut
     * - Recupere l'adresse par defaut actuelle de l'utilisateur
     * - Verifie qu'une adresse par defaut existe
     * - Affiche le formulaire avec le flag isDefaut = true
     * - Permet la modification de l'adresse par defaut
     */
    public function modifierAdresseDefaut()
    {
        $adresseModel = new \App\Models\AdresseModel();
        $userId = session()->get('user_id');

        // Récupérer l'adresse par défaut actuelle
        $adresseDefaut = $adresseModel->where('user_id', $userId)->where('is_defaut', 1)->first();

        if (!$adresseDefaut) {
            return redirect()->to('/profil')->with('error', 'Aucune adresse par défaut trouvée.');
        }

        return view('AdresseModifier', [
            'adresse' => $adresseDefaut,
            'isDefaut' => true
        ]);
    }

    /**
     * Traitement de la mise a jour de l'adresse par defaut
     * - Recupere l'adresse par defaut actuelle
     * - Met a jour tous les champs de l'adresse par defaut
     * - Conserve le statut is_defaut = 1
     * - Redirige vers le profil avec message de confirmation
     * - Permet la modification de l'adresse par defaut
     */
    public function updateAdresseDefaut()
    {
        $adresseModel = new \App\Models\AdresseModel();
        $userId = session()->get('user_id');

        // Récupérer l'adresse par défaut actuelle
        $adresseDefaut = $adresseModel->where('user_id', $userId)->where('is_defaut', 1)->first();

        if (!$adresseDefaut) {
            return redirect()->to('/profil')->with('error', 'Aucune adresse par défaut trouvée.');
        }

        $data = [
            'nom' => $this->request->getPost('nom'),
            'prenom' => $this->request->getPost('prenom'),
            'adresse' => $this->request->getPost('adresse'),
            'complement' => $this->request->getPost('complement'),
            'code_postal' => $this->request->getPost('code_postal'),
            'ville' => $this->request->getPost('ville'),
            'departement' => $this->request->getPost('departement'),
            'pays' => $this->request->getPost('pays'),
            'telephone' => $this->request->getPost('telephone'),
        ];

        $adresseModel->update($adresseDefaut['id'], $data);
        return redirect()->to('/profil')->with('success', 'Adresse par défaut modifiée.');
    }

    /**
     * Creation d'une adresse par defaut a partir des informations utilisateur
     * - Verifie qu'aucune adresse par defaut n'existe deja
     * - Controle que l'utilisateur a des informations d'adresse completes
     * - Cree une nouvelle adresse par defaut avec is_defaut = 1
     * - Utilise les informations du profil utilisateur
     * - Redirige vers le profil avec message de confirmation
     */
    public function creerAdresseDefaut()
    {
        $userModel = new \App\Models\UserModel();
        $adresseModel = new \App\Models\AdresseModel();
        $userId = session()->get('user_id');
        $user = $userModel->find($userId);

        // Vérifier qu'il n'y a pas déjà d'adresse par défaut
        $adresseDefautExistante = $adresseModel->where('user_id', $userId)->where('is_defaut', 1)->first();
        if ($adresseDefautExistante) {
            return redirect()->to('/profil')->with('error', 'Vous avez déjà une adresse par défaut.');
        }

        // Vérifier que l'utilisateur a des infos d'adresse
        if (empty($user['adresse']) || empty($user['code_postal']) || empty($user['ville'])) {
            return redirect()->to('/profil')->with('error', 'Veuillez d\'abord compléter vos informations d\'adresse dans votre profil.');
        }

        // Créer l'adresse par défaut
        $nouvelleAdresse = [
            'user_id' => $userId,
            'nom' => $user['nom'] ?: $user['nomcompte'],
            'prenom' => $user['prenom'] ?: $user['prenomcompte'],
            'titre' => 'Adresse par défaut',
            'adresse' => $user['adresse'],
            'complement' => $user['complement'],
            'code_postal' => $user['code_postal'],
            'ville' => $user['ville'],
            'departement' => $user['departement'],
            'pays' => $user['pays'] ?: 'France',
            'telephone' => $user['telephone'],
            'is_defaut' => 1
        ];

        $adresseModel->save($nouvelleAdresse);
        return redirect()->to('/profil')->with('success', 'Adresse par défaut créée à partir de vos informations.');
    }
}