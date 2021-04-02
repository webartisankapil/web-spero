<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card" v-if="!Object.keys(productDetails).length">
          <div class="card-header">
            <h4>Products</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table mb-0">
                <thead class="table-light">
                  <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Size</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <template v-if="products">
                    <tr v-for="product in products">
                      <td> {{product.id}}</td>
                      <td>
                        <img :src="product.image_url" @error="imageNotFound" width="40" height="30"/>
                      </td>
                      <td>{{product.price}}</td>
                      <td>
                          <span class="badge badge-pill" :class="product.instock ? 'badge-success' : 'badge-danger'">{{product.instock ? 'In stock' : 'Out of stock'}}</span>
                      </td>
                      <td>{{product.size.toUpperCase()}}</td>
                      <td><a href="javaScript:void(0)" @click="getProductDetail(product.id)">view</a></td>
                    </tr>
                  </template>
                  <template v-else>
                    <tr>
                      <td>no products found</td>
                    </tr>
                  </template>
                </tbody>
              </table>
              <div v-if="products && total">
                  <paginate
                    v-model="page"
                    :click-handler="getProducts"
                    :page-count="total"
                    :container-class="'ui pagination menu'"
                    :page-link-class="'item'"
                    :prev-link-class="'item'"
                    :next-link-class="'item'"
                    :break-view-link-class="'break-view-link'"
                    :no-li-surround="true"
                  ></paginate>
              </div>
            </div>
          </div>
        </div>
        <div class="card" v-else>
          <ProductDetails :product="productDetails" @clicked="resetProductDetails"></ProductDetails>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
    import ProductDetails from "./ProductDetails.vue";
    export default {
        components : {
          ProductDetails,
        },
        data () {
          return {
            page: 1,
            products: {},
            productDetails: {},
            total: 0,
          }
        },
        mounted() {
            this.getProducts();
        },
        methods: {
          getProducts(){
              axios.get('/products?page='+this.page).then(resp =>{
                var products = resp.data.products;
                this.products = products.data;
                this.total = products.last_page;
              });
          },
          getProductDetail(id)
          {
            axios.get('/products/'+id).then(resp => {
              this.productDetails = resp.data.product;
            });
          },
          resetProductDetails() {
            this.productDetails = {};
          },
          imageNotFound(event) {
             event.target.src = "/images/image-not-found.jpg"
          }
        }
    }
</script>
<style media="screen" scoped>

</style>
