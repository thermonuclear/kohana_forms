<form method="post">
  <div>
    <el-button @click="getContent">Показать новость</el-button>
  </div>
</form>


<script>
  var app = new Vue({
    el: '#app',
    data: {

    },

    methods: {
      // фокус или изменения инпута формы
      getContent: async function (event) {
        let response = await fetch('/ajax/content', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json;charset=utf-8'
          },
          body: JSON.stringify({
            selected: this.selected,
            name: event.target.name,
          })
        })

        let result = await response.json()
        console.log(result);
      },
    }

  })
</script>
