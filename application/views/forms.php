<form>
  <div>
    <button type="button" class="btn btn-primary" @click="getContent">Показать новость</button>
  </div>
</form>
<div v-show="content.title">
  <ul class="list-group">
    <li class="list-group-item">title: {{ content.title }}</li>
    <li class="list-group-item">second_title: {{ content.second_title }}</li>
    <li class="list-group-item">url: {{ content.image }}</li>
</div>

<form class="form-inline">
  <input type="text" class="form-control mb-2 mr-sm-2" placeholder="login" v-model="registration.login">
  <input type="email" class="form-control mb-2 mr-sm-2" placeholder="email" v-model="registration.email">
  <input type="password" class="form-control mb-2 mr-sm-2" placeholder="password" v-model="registration.password">
  <div class="form-group">
    <button type="button" class="btn btn-primary mb-2" @click="registrate">Регистрация</button>
  </div>
</form>
<div v-if="registration.result">
  <ul class="list-group">
    <li class="list-group-item">Регистрация выполнена успешно</li>
</div>
<div v-if="registration.errors.length">
  <ul class="list-group">
    <li class="list-group-item" v-for="error in registration.errors">{{ error }}</li>
</div>

<form class="form-inline">
  <input type="text" class="form-control mb-2 mr-sm-2" placeholder="login" v-model="login.login">
  <input type="password" class="form-control mb-2 mr-sm-2" placeholder="password" v-model="login.password">
  <div class="form-group">
    <button type="button" class="btn btn-primary mb-2" @click="makeLogin">Логин</button>
  </div>
</form>
<div v-if="login.success">
  <ul class="list-group">
    <li class="list-group-item">Вход выполнен успешно</li>
</div>
<div v-if="login.error">
  <ul class="list-group">
    <li class="list-group-item">Вход не выполнен</li>
</div>

<form class="form-inline">
  <div class="form-group">
    <button type="button" class="btn btn-primary mb-2" @click="makeLogout">Выйти</button>
  </div>
</form>
<div v-if="logout.success">
  <ul class="list-group">
    <li class="list-group-item">Выход выполнен успешно</li>
</div>
<div v-if="logout.error">
  <ul class="list-group">
    <li class="list-group-item">Выход не выполнен</li>
</div>


<form class="form-inline">
  <input type="text" class="form-control mb-2 mr-sm-2" placeholder="login" v-model="forgotlogin.login">
  <div class="form-group">
    <button type="button" class="btn btn-primary mb-2" @click="forgot">Восстановить</button>
  </div>
</form>
<div v-if="forgotlogin.link">
  <ul class="list-group">
    <li class="list-group-item">Ссылка для восстановления пароля - {{ forgotlogin.link }}</li>
</div>


<form class="form-inline">
  <div class="form-group">
    <select class="form-control mr-sm-2" v-model="rate.selected">
      <option value="GBP">GBP</option>
      <option value="USD">USD</option>
      <option value="EUR">EUR</option>
    </select>
  </div>

  <div class="form-group">
    <button type="button" class="btn btn-primary" @click="getRate">Получить курс валюты</button>
  </div>
</form>
<div v-show="rate.value">
  <ul class="list-group">
    <li class="list-group-item">{{ rate.current }}: {{ rate.value }}</li>
</div>


<form class="form-inline">
  <input type="text" class="form-control mb-2 mr-sm-2" placeholder="word" v-model="word.value">
  <div class="form-group">
    <button type="button" class="btn btn-primary mb-2" @click="saveWord">Добавить слово</button>
  </div>
</form>
<div v-if="word.show">
  <ul class="list-group">
    <li class="list-group-item" v-if="word.success">Слово сохранено</li>
    <li class="list-group-item" v-if="!word.success">Слово не сохранено</li>
</div>

<form class="form-inline">
  <div class="form-group">
    <button type="button" class="btn btn-primary mb-2" @click="getWords(1)">Показать слова</button>
  </div>
</form>
<div v-if="words.words.length">
  <ul class="list-group">
    <li class="list-group-item" v-for="word in words.words">{{ word }}</li>
  <nav style="margin-top: 10px" v-if="words.paginator.length>1">
    <ul class="pagination">
      <li class="page-item" v-for="(page, ind) in words.paginator" :class="{ active: page == words.curPage }">
        <a class="page-link" href="#" @click="getWords(page)" v-if="ind==0 && words.prev">&laquo;</a>
        <a class="page-link" href="#" @click="getWords(page)" v-else-if="ind==words.paginator.length-1 && words.next">&raquo;</a>
        <a class="page-link" href="#" @click="getWords(page)" v-else>{{ page }}</a>
      </li>
    </ul>
  </nav>
</div>


<form class="form-inline">
  <div class="form-group">
    <button type="button" class="btn btn-primary mb-2" @click="getWordstat">wordstat</button>
  </div>
</form>
<table class="table" v-if="wordstat.length" style="max-width: 600px">
  <thead>
  <tr>
    <th scope="col">word</th>
    <th scope="col">stat</th>
  </tr>
  </thead>
  <tbody>
  <tr v-for="item in wordstat">
    <td>{{ item.word }}</td>
    <td>{{ item.stat }}</td>
  </tr>
  </tbody>
</table>
