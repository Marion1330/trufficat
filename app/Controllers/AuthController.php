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

}