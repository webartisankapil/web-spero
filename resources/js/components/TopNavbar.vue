<template>
  <nav class="navbar navbar-expand-sm bg-light">
    <div class="container">
      <a class="navbar-brand" href="#">
       <h2>Webspero</h2>
      </a>
      <ul class="navbar-nav">
        <li class="nav-item mr-2">
          <a class="nav-link notification" href="/cart"><i class="fa fa-shopping-cart" style="font-size:28px;" title="items"><span class="badge">{{items}}</span></i></a>
        </li>
        <template v-if="user">
          <li class="nav-item" >
            <a class="nav-link mt-2" >
              {{ user.name }}
            </a>
          </li>
          <li class="nav-item" >
            <button type="button" class="btn btn-info btn-sm nav-link mt-2" @click="logout">
              <i class="fa fa-sign-out">Log out</i>
            </button>
          </li>
        </template>
        <template v-else>
          <li class="nav-item" >
            <a href="/login" class="btn btn-primary btn-sm nav-link mt-2">
              <i class="fa fa-sign-out">Log In</i>
            </a>
          </li>
        </template>
      </ul>
    </div>
  </nav>
</template>

<script>
import {bus} from '../app';
export default {
    data() {
        return {
          items : 0,
          user : null
        }
    },
    created (){
      bus.$on('updateCart', () => {
        this.countItems();
      });
    },
    mounted() {
        this.user = window.user ? window.user : null;
        this.countItems();
    },
    methods : {
      countItems() {
        axios.get('/cart/count-items').then(resp => {
            if (resp.status == 200) {
                this.items = resp.data.items;
            }
        });
      },
      logout() {
        axios.post('/logout').then(resp =>{
            if (resp.status == 204) {
                window.location.reload();
            }
        }).catch(err => {
            console.log(err);
        });
      }
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
