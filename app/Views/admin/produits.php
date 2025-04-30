<h1>Gestion des produits</h1>
<a href="/admin/produit/ajouter" class="btn">Ajouter un produit</a>

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Description</th>
            <th>Animal</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($produits as $produit): ?>
            <tr>
                <td><?= esc($produit['nom']) ?></td>
                <td><?= esc($produit['description']) ?></td>
                <td><?= ucfirst(esc($produit['animal'])) ?></td>
                <td>
                    <a href="/admin/produit/modifier/<?= esc($produit['id']) ?>">Modifier</a>
                    <a href="/admin/produit/supprimer/<?= esc($produit['id']) ?>">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
