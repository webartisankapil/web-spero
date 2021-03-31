<template>
  <nav class="navbar navbar-expand-sm bg-light">
    <div class="container">
      <a class="navbar-brand" href="#">
       <h2>Webspero</h2>
      </a>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link notification" href="#"><i class="fa fa-shopping-cart" style="font-size:28px;"><span class="badge">0</span></i></a>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script>
    export default {
        mounted() {
            console.log('Component navbar.')
        }
    }
</script>
<style scoped>
.notification {
text-decoration: none;
padding: 15px 26px;
position: relative;
display: inline-block;
border-radius: 2px;
}

.notification .badge {
position: absolute;
top: 9px;
right: -1px;
padding: 0px 4px;
border-radius: 50%;
background: red;
color: white;
font-size: 48%;
}
</style>
