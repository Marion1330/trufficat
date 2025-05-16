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
            return redirect()->back()->with('error', 'Les mots de passe ne correspondent pas.');
        }

        $userModel = new UserModel();

        // Vérifie si l'e-mail existe déjà
        if ($userModel->where('email', $email)->first()) {
            return redirect()->back()->with('error', 'Cet e-mail est déjà utilisé.');
        }

        $data = [
            'nom' => $nom,
            'prenom' => $prenom,
            'username' => $nom . ' ' . $prenom,
            'email' => $email,
            'password' => $password, // <-- PAS de password_hash ici !
            'role' => 'client',
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
                'email'   => $user['email'],
                'nom'     => $user['nom'],
                'role'    => $user['role'],
            ]);

            // Rediriger selon le rôle
            if ($user['role'] === 'admin') {
                return redirect()->to('/')->with('success', 'Bienvenue, administrateur.');
            } else {
                return redirect()->to('/')->with('success', 'Bienvenue sur Trufficat !');
            }
        }

        return redirect()->back()->with('error', 'Identifiants invalides.');
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

        // On considère que l'adresse principale est toujours par défaut sauf si une adresse secondaire a is_principale=1
        $adressePrincipaleDefaut = !$adresseModel->where('user_id', $userId)->where('is_principale', 1)->first();

        $adresses = $adresseModel
            ->where('user_id', $userId)
            ->findAll();

        return view('VueProfil', [
            'user' => $user,
            'adresses' => $adresses,
            'adressePrincipaleDefaut' => $adressePrincipaleDefaut
        ]);
    }

    public function updateProfil()
    {
        $userModel = new \App\Models\UserModel();
        $id = session('user_id');
        $data = [
            'nom' => $this->request->getPost('nom'),
            'prenom' => $this->request->getPost('prenom'),
            'telephone' => $this->request->getPost('telephone'),
            'adresse' => $this->request->getPost('adresse'),
            'complement' => $this->request->getPost('complement'),
            'code_postal' => $this->request->getPost('code_postal'),
            'ville' => $this->request->getPost('ville'),
            'pays' => $this->request->getPost('pays'),
        ];
        $userModel->update($id, $data);
        return redirect()->to('/profil')->with('success', 'Profil mis à jour.');
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
            'titre' => $this->request->getPost('titre'),
            'adresse' => $this->request->getPost('adresse'),
            'complement' => $this->request->getPost('complement'),
            'code_postal' => $this->request->getPost('code_postal'),
            'ville' => $this->request->getPost('ville'),
            'departement' => $this->request->getPost('departement'),
            'pays' => $this->request->getPost('pays'),
            'telephone' => $this->request->getPost('telephone'),
            'is_principale' => $this->request->getPost('is_principale') ? 1 : 0,
        ];

        $adresseModel->save($data);
        return redirect()->to('/profil')->with('success', 'Adresse secondaire ajoutée.');
    }

    public function modifierAdresse($id)
    {
        $adresseModel = new \App\Models\AdresseModel();
        $adresse = $adresseModel->find($id);

        if (!$adresse || $adresse['user_id'] != session()->get('user_id')) {
            return redirect()->to('/profil')->with('error', 'Adresse non trouvée.');
        }

        return view('AdresseModifier', ['adresse' => $adresse]);
    }

    public function updateAdresse($id)
    {
        $adresseModel = new \App\Models\AdresseModel();
        $userId = session()->get('user_id');

        // Si définie principale, désactiver les autres
        if ($this->request->getPost('is_principale')) {
            $adresseModel->where('user_id', $userId)
                ->set(['is_principale' => 0])
                ->update();
        }

        $data = [
            'titre' => $this->request->getPost('titre'),
            'adresse' => $this->request->getPost('adresse'),
            'complement' => $this->request->getPost('complement'),
            'code_postal' => $this->request->getPost('code_postal'),
            'ville' => $this->request->getPost('ville'),
            'departement' => $this->request->getPost('departement'),
            'pays' => $this->request->getPost('pays'),
            'telephone' => $this->request->getPost('telephone'),
            'is_principale' => $this->request->getPost('is_principale') ? 1 : 0,
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
        }

        return redirect()->to('/profil')->with('success', 'Adresse supprimée.');
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
            return redirect()->back()->with('error', 'Ancien mot de passe incorrect.');
        }
        if ($nouveau !== $confirmer) {
            return redirect()->back()->with('error', 'Les mots de passe ne correspondent pas.');
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
        $userModel = new \App\Models\UserModel();
        $userId = session()->get('user_id');

        $adresse = $adresseModel->where('user_id', $userId)->find($id);
        if (!$adresse) {
            return redirect()->to('/profil')->with('error', 'Adresse non trouvée.');
        }

        // Sauvegarde l'ancienne adresse principale dans adresses
        $user = $userModel->find($userId);
        $adresseModel->insert([
            'user_id' => $userId,
            'titre' => 'Ancienne principale',
            'adresse' => $user['adresse'],
            'complement' => $user['complement'],
            'code_postal' => $user['code_postal'],
            'ville' => $user['ville'],
            'departement' => $user['departement'],
            'pays' => $user['pays'],
            'telephone' => $user['telephone'],
            'is_principale' => 0
        ]);

        // Met à jour l'utilisateur avec la nouvelle adresse principale
        $userModel->update($userId, [
            'adresse' => $adresse['adresse'],
            'complement' => $adresse['complement'],
            'code_postal' => $adresse['code_postal'],
            'ville' => $adresse['ville'],
            'departement' => $adresse['departement'],
            'pays' => $adresse['pays'],
            'telephone' => $adresse['telephone'],
        ]);

        // Met toutes les adresses secondaires à is_principale=0
        $adresseModel->where('user_id', $userId)->set(['is_principale' => 0])->update();

        // Supprime l'adresse devenue principale des adresses secondaires
        $adresseModel->delete($id);

        return redirect()->to('/profil')->with('success', 'Adresse principale modifiée.');
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

    public function modifierAdressePrincipale()
    {
        $userModel = new \App\Models\UserModel();
        $userId = session()->get('user_id');

        $data = [
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

    public function afficherFormulaireAdressePrincipale()
    {
        $userModel = new \App\Models\UserModel();
        $userId = session()->get('user_id');
        $user = $userModel->find($userId);

        // On passe les données du user sous le nom "adresse" pour réutiliser la vue
        return view('AdresseModifier', [
            'adresse' => [
                'id' => 'principale',
                'titre' => 'Adresse principale',
                'adresse' => $user['adresse'],
                'complement' => $user['complement'],
                'code_postal' => $user['code_postal'],
                'ville' => $user['ville'],
                'departement' => $user['departement'],
                'pays' => $user['pays'],
                'telephone' => $user['telephone'],
                'is_principale' => true
            ],
            'isPrincipale' => true // Pour adapter l'action du formulaire
        ]);
    }

    public function afficherFormulaireInfos()
    {
        $userModel = new \App\Models\UserModel();
        $userId = session()->get('user_id');
        $user = $userModel->find($userId);
        return view('InfosModifier', ['user' => $user]);
    }

    public function modifierInfos()
    {
        $userModel = new \App\Models\UserModel();
        $userId = session()->get('user_id');
        $data = [
            'nom' => $this->request->getPost('nom'),
            'prenom' => $this->request->getPost('prenom'),
            'email' => $this->request->getPost('email'),
            'telephone' => $this->request->getPost('telephone'),
        ];
        $userModel->update($userId, $data);
        return redirect()->to('/profil')->with('success', 'Informations modifiées.');
    }

}
