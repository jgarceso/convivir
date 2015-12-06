<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    echo "<script>SiteName = '". $this->config->site_url() ."';</script>";
    echo '<link type="text/css" rel="stylesheet" href="' . $this->config->site_url() . $this->convivir->core_css_path . 'jquery_plugins/jBox.css" />';
    echo '<link type="text/css" rel="stylesheet" href="' . $this->config->site_url() . $this->convivir->core_css_path . 'jquery_plugins/w2ui-1.4.3.min.css" />';
    echo '<link type="text/css" rel="stylesheet" href="' . $this->config->site_url() . $this->convivir->css_path . 'convivir.css" />';
    foreach ($css_files as $file):
        ?>
        <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
    <?php endforeach; ?>
    <?php foreach ($js_files as $file): ?>
        <script src="<?php echo $file; ?>"></script>
    <?php endforeach; ?>

    <?php
    echo '<script src="' . $this->config->site_url() . $this->convivir->js_path . 'lib/jquery.validate.min.js"></script>';
    echo '<script src="' . $this->config->site_url() . $this->convivir->core_js_path . 'jquery_plugins/jBox.min.js"></script>';
    echo '<script src="' . $this->config->site_url() . $this->convivir->core_js_path . 'jquery_plugins/w2ui-1.4.3.min.js"></script>';
    echo '<script src="' . $this->config->site_url() . $this->convivir->js_path . 'archivos/common.js"></script>';
    if ($this->controllerName != "") {
        echo '<script src="' . $this->config->site_url() . $this->convivir->js_path . 'archivos/usuario.js"></script>';
    }
    ?>

</head>

