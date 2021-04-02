<template>
  <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header d-flex">
              <h4>Shopping Cart</h4>
              <a href="/home" class="btn btn-info ml-auto">Back</a>
            </div>
            <div class="card-body">
              <template v-if="items.length">
                <div class="row mb-2" v-for="(item, index) in items" :key="index">
                  <div class="col-md-8 d-flex">
                  <div>
                    <img :src="item.product.image_url" @error="imageNotFound" width="300" height="250"/>
                  </div>
                  <div class=" flex-fill">
                    <ul class="list-group ml-1">
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        <h6>Color</h6>
                        <span class="badge badge-primary ">{{item.product.color}}</span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        <h6>Price</h6>
                        <span class="badge badge-primary badge-pill" v-text="item.total"></span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        <h6>Quantity</h6>
                        <select class="badge" v-model="items[index].quantity" @change="changeQuantity(item.id, $event)" >
                           <template v-if="item.product.quantity > 1">
                             <option v-for="number in (item.product.quantity)" :key="number" :value="number" v-text="number"></option>
                           </template>
                           <template v-else>
                              <option selected hidden>{{item.quantity}}</option>
                              <option disabled >0</option>
                           </template>
                        </select>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        <h6>Size</h6>
                        <span>{{item.product.size.toUpperCase()}}</span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="badge badge-pill" :class="item.product.instock ? 'badge-success' : 'badge-danger'">{{item.product.instock ? 'In stock' : 'Out of stock'}}</span>
                        <button type="button" class="btn btn-danger btn-sm" name="button" @click="removeItem(item.id)">Remove</button>
                      </li>
                    </ul>
                  </div>
                </div>
                </div>
              </template>
              <template v-else>
                  <div>
                    cart is empty
                  </div>
              </template>
          </div>
          <div class="card-footer" v-if="items.length">
            <span>Subtotal</span><span>( {{subtotal}} items): {{quantity}}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import {bus} from '../app';
export default {
  data () {
    return {
      items : {},
      subtotal : 0,
      quantity : 0
    }
  },
  mounted () {
    this.getItems();
  },
  methods : {
    getItems() {
      axios.get('cart/items').then(resp => {
        console.log(resp);
        if (resp.status == 200) {
          this.items = resp.data.items;
          this.subtotal = resp.data.subtotal;
          this.quantity = resp.data.quantity;
        }
      });
    },
    imageNotFound(event) {
       event.target.src = "/images/image-not-found.jpg"
    },
    removeItem(id) {
      if(confirm("Do you really want to delete?")){
        axios.post('/cart/remove', {cartId: id}).then(resp => {
          if (resp.status == 204) {
            bus.$emit('updateCart');
            this.getItems();
          }
        });
      }
    },
    changeQuantity(id, event) {
      var quantity = event.target.value;
      if(confirm("Do you really want to change quantity?")){
        axios.post('/cart/update', {id : id, quantity : quantity }).then(resp => {
          if (resp.status == 200) {
              bus.$emit('updateCart');
              this.getItems();
          }
        });
      } else {
        this.getItems();
      }
    }
  },
  watch: {

  }
}
</script>
