<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= lang('Errors.badRequest') ?></title>
    <link rel="stylesheet" href="/css/errors.css">
            color: #999;
        }
        a:active,
        a:link,
        a:visited {
            color: #dd4814;
        }
    </style>
</head>
<body>
<div class="wrap">
    <h1>400</h1>

    <p>
        <?php if (ENVIRONMENT !== 'production') : ?>
            <?= nl2br(esc($message)) ?>
        <?php else : ?>
            <?= lang('Errors.sorryBadRequest') ?>
        <?php endif; ?>
    </p>
</div>
</body>
</html>
