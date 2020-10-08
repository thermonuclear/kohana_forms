<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <link rel="stylesheet" href="/css/element_ui.css">
  <link rel="stylesheet" href="/css/style.css">
  <script src="/js/vue.js"></script>
  <script src="/js/element_ui.js"></script>
  <title>web form</title>
</head>
<body>
  <noscript>
    <strong>We're sorry but webform doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
  </noscript>

  <div id="app" v-cloak>
    <el-main>
        <?= $content; ?>
    </el-main>
  </div>
  <script src="/js/webform.js"></script>
</body>
</html>
