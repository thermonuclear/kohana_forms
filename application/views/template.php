<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <link rel="stylesheet" href="/css/bootstrap.min.css">
  <link rel="stylesheet" href="/css/style.css">
  <script src="/js/vue.js"></script>
  <title>web form</title>
</head>
<body>
<noscript>
  <strong>We're sorry but webform doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
</noscript>

<div id="app" v-cloak>
  <div class="container">
      <?= $content; ?>
  </div>
</div>
<script>
  var app = new Vue({
    el: '#app',
    data: {
      content: {
        image: '',
        title: '',
        second_title: '',
      },
      registration: {
        email: '',
        password: '',
        login: '',
        result: '',
        errors: [],
      },
      login: {
        login: '',
        password: '',
        success: false,
        error: false,
      },
      logout: {
        success: false,
        error: false,
      },
      forgotlogin: {
        login: '',
        link: '',
      },
      rate: {
        selected: '',
        current: '',
        value: '',
      },
      word: {
        value: '',
        success: '',
        show: false,
      },
      words: {
        words: [],
        paginator: [],
        curPage: 1,
      },
      wordstat: [],
    },

    methods: {
      // content
      getContent: async function () {
        let response = await fetch('/ajax/content', {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json;charset=utf-8'
          },
          // body: JSON.stringify({
          //   selected: this.selected,
          //   name: event.target.name,
          // })
        })

        let result = await response.json()
        if (result.title) {
          this.content = result
        }
      },
      // registration
      registrate: async function () {
        let response = await fetch('/ajax/registration', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json;charset=utf-8'
          },
          body: JSON.stringify(this.registration)
        })

        let result = await response.json();

        this.registration.result = false;
        this.registration.errors = [];
        if (result.success) {
          this.registration.result = true;
        } else {
          this.registration.errors = result.errors;
        }
      },
      // login
      makeLogin: async function () {
        let response = await fetch('/ajax/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json;charset=utf-8'
          },
          body: JSON.stringify(this.login)
        })

        let result = await response.json();
        this.login.success = false;
        this.login.error = false;
        if (result.success) {
          this.login.success = result.success;
        } else {
          this.login.error = true;
        }
      },
      // logout
      makeLogout: async function () {
        let response = await fetch('/ajax/logout', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json;charset=utf-8'
          },
        })

        let result = await response.json();
        this.logout.success = false;
        this.logout.error = false;
        if (result.success) {
          this.logout.success = result.success;
        } else {
          this.logout.error = true;
        }
      },
      // forgot
      forgot: async function () {
        if (!this.forgotlogin.login) return;
        let response = await fetch('/ajax/forgot', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json;charset=utf-8'
          },
          body: JSON.stringify({'login': this.forgotlogin.login})
        })

        this.forgotlogin.link = "";
        let result = await response.json();

        this.forgotlogin.link = result.link ? result.link : 'ссылка не создана';
      },
      // content
      getRate: async function () {
        if (!this.rate.selected) return;
        let response = await fetch('/ajax/exchangerate', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json;charset=utf-8'
          },
          body: JSON.stringify({'valute': this.rate.selected})
        })

        let result = await response.json()
        this.rate.current = this.rate.selected;
        this.rate.value = result.value;
      },
      // word
      saveWord: async function () {
        if (!this.word.value) return;
        this.word.show = false;

        let response = await fetch('/ajax/word', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json;charset=utf-8'
          },
          body: JSON.stringify({'word': this.word.value})
        })

        let result = await response.json()
        this.word.show = true;
        this.word.success = result.success;
      },
      // words
      getWords: async function (page) {
        let response = await fetch('/ajax/words', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json;charset=utf-8'
          },
          body: JSON.stringify({'page': page})
        })

        let result = await response.json();
        this.words.words = result.words;
        this.words.curPage = page;
        this.words.prev = result.prev;
        this.words.next = result.next;
        this.words.paginator = result.paginator;
      },
      // wordstat
      getWordstat: async function (event) {
        let response = await fetch('/ajax/wordstat', {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json;charset=utf-8'
          },
        })

        let result = await response.json()
        this.wordstat = result.wordstat;
      },
    }

  })
</script>
<script src="/js/webform.js"></script>
</body>
</html>
