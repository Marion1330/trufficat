<h1>Modifier le produit</h1>
<form action="/admin/produit/modifier/<?= esc($produit['id']) ?>" method="post" enctype="multipart/form-data">
    <label for="nom">Nom</label>
    <input type="text" name="nom" value="<?= esc($produit['nom']) ?>" required>

    <label for="description">Description</label>
    <textarea name="description" required><?= esc($produit['description']) ?></textarea>

    <label for="animal">Animal</label>
    <select name="animal">
        <option value="chien" <?= $produit['animal'] == 'chien' ? 'selected' : '' ?>>Chien</option>
        <option value="chat" <?= $produit['animal'] == 'chat' ? 'selected' : '' ?>>Chat</option>
    </select>

    <label for="image">Image</label>
    <input type="file" name="image">

    <button type="submit">Modifier</button>
</form>
