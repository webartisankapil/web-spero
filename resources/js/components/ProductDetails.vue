<template>
  <div>
      <div class="card-header d-flex">
        <h4>Product Details</h4>
        <button type="button" class="btn btn-info ml-auto" name="button" @click="backToProducts"> Back</button>
      </div>
      <div class="card-body">
        <div class="row justify-content-center">
          <div class="col-md-8 d-flex">
            <div>
                <img :src="product.image_url" @error="imageNotFound" width="300" height="250"/>
            </div>
            <div class=" flex-fill">
              <ul class="list-group ml-1">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <h6>Color</h6>
                  <span class="badge badge-primary ">{{product.color}}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <h6>Price</h6>
                  <span class="badge badge-primary badge-pill">{{product.price}}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <h6>Stock</h6>
                  <span class="badge badge-primary badge-pill">{{product.instock}}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <h6>Quantity</h6>
                  <span class="badge badge-primary badge-pill">{{product.quantity ? product.quantity : 0 }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <h6>Size</h6>
                  <span>{{product.size.toUpperCase()}}</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 col-span-2">
              <button  v-if="product.instock" type="button" class="btn btn-info mt-2" @click="addToCart(product.id)" style="width: 100%" name="button"><i class="fa fa-shopping-cart" aria-hidden="true"> Add to cart</i></button>
              <button  v-else type="button" disabled class="btn btn-info mt-2" style="width: 100%" name="button"><i class="fa fa-shopping-cart" aria-hidden="true"> Out Of stock</i></button>
            </div>
        </div>
    </div>
  </div>
</template>
<script>
import {bus} from '../app';
export default {
  data() {
    return {
      user: null,
    }
  },
  props: ['product'],
  mounted () {
    this.user = window.user ? window.user : null;
  },
  methods : {
    backToProducts() {
      this.$emit('clicked')
    },
    imageNotFound(event) {
       event.target.src = "/images/image-not-found.jpg"
    },
    addToCart(id) {
        if (this.user == null) {
          alert('To add this product to cart you have to login first');
          return;
        }
        if(confirm("Do you really want to add to cart ?")){
          axios.post('/cart/add', {productId:id}).then(resp =>{
            console.log(resp.status);
            if (resp.status == 200) {
                bus.$emit('updateCart');
            }
          }).catch(err => {
              alert(err.response.data.message);
          });
        }
    }
  }
}
</script>
