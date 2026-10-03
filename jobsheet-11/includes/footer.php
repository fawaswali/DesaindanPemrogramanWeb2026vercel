</main>

    <footer>
        <p>&copy; 2026 Kost Papa &mdash; Jobsheet 11 (Security Audit & Hardening)</p>
    </footer>
    <script src="<?php echo $base; ?>assets/js/app.js"></script>
    <?php if (!empty($extra_scripts)): foreach ($extra_scripts as $src): ?>
    <script src="<?php echo $src; ?>"></script>
    <?php endforeach;
    endif; ?>
</body>
</html>