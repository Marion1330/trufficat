<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends BaseController
{
    public function inscription()
    {
        return view('VueInscription');
    }

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

        $userModel->save($data);

        return redirect()->to('/connexion')->with('success', 'Inscription réussie. Vous pouvez maintenant vous connecter.');
    }

    public function connexion()
    {
        return view('VueConnexion');
    }

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

    public function deconnexion()
    {
        session()->destroy();
        return redirect()->to('/')->with('success', 'Déconnexion réussie.');
    }

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


    public function ajouterAdresse()
    {
        return view('AdresseAjouter');
    }

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

    public function modifierAdresse($id)
    {
        $adresseModel = new \App\Models\AdresseModel();
        $adresse = $adresseModel->find($id);

        if (!$adresse || $adresse['user_id'] != session()->get('user_id')) {
            return redirect()->to('/profil')->withInput()->with('error', 'Adresse non trouvée.');
        }

        return view('AdresseModifier', ['adresse' => $adresse]);
    }

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

    public function changerMotDePasse()
    {
        return view('ChangerMotDePasse');
    }

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

        // Le hash sera fait automatiquement par UserModel
        $userModel->update($userId, ['password' => $nouveau]);
        return redirect()->to('/profil')->with('success', 'Mot de passe changé.');
    }

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

    // Pour définir une adresse supplémentaire comme défaut
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

    // Quand une adresse devient principale
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

    // Pour remettre l'adresse principale comme défaut
    public function definirPrincipaleDefaut()
    {
        $adresseModel = new \App\Models\AdresseModel();
        $userId = session()->get('user_id');

        // Met toutes les adresses secondaires à is_principale=0
        $adresseModel->where('user_id', $userId)->set(['is_principale' => 0])->update();

        return redirect()->to('/profil')->with('success', 'Adresse principale définie par défaut.');
    }


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
            'isPrincipale' => true
        ]);
    }

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

    public function afficherFormulaireInfos()
    {
        $userModel = new \App\Models\UserModel();
        $userId = session()->get('user_id');
        $user = $userModel->find($userId);
        return view('InfosModifier', ['user' => $user]);
    }

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