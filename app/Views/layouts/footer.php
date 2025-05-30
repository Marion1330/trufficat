</main>
<footer class="footer">
<p>Service client: <a href="mailto:contact@Trufficat.com">contact@Trufficat.com</a></p>
<p>&copy; <?= date('Y') ?> Trufficat. Tous droits réservés.</p>
</footer>

<script src="<?= base_url('js/global.js') ?>"></script>
<script>
// Initialiser les variables globales
window.TrufficatGlobal.init({
    baseUrl: '<?= base_url() ?>'
});
</script>
<script src="<?= base_url('js/carrousel.js') ?>"></script>
<script src="<?= base_url('js/produits-liste.js') ?>"></script>
</body>
</html>
