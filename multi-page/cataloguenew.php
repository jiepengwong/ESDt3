<?php


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <!-- Vue Application -->
    <script src="https://unpkg.com/vue@3"></script>
    <!--  Bootstrap -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
  </head>
  <body>
    <div id="app">
      <!-- Navbar goes here -->
      <nav class="navbar navbar-light bg-light static-top">
        <div class="container">
          <a class="navbar-brand" href="#!">Start Bootstrap</a>
          <a class="btn btn-primary" href="#signup">Sign Up</a>
        </div>
      </nav>

      <!-- Header -->

      <header class="masthead bg-success p-5">
        <div class="container position-relative">
          <div class="row justify-content-center">
            <div class="col-xl-6">
              <div class="text-center text-white">
                <!-- Page heading-->
                <h1 class="mb-5">Henesy Market Catalogue!</h1>

                <!-- Search bar input-->
                <div class="row">
                  <div class="col">
                    <input
                      class="form-control form-control-lg"
                      type="text"
                      placeholder="Type your desired item here"
                      v-model="search"
                  
                    />
                  </div>
                </div>

                <div class="row">
                  <div v-for="category in categories" :key="category" class="col-sm-2">
                    <button @click="filterPosts(category)" class="btn btn-success p-3" @click="filter">{{category}}</button>
                   
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </header>


      <section id="listings">

        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <h2 class="mb-5 py-5">Listings</h2>
            </div>
          </div>
          <div class="row">
            <div v-for="result in filterListings" :key="result" class="col-lg-4 col-md-6 mb-4">
              <div class="card h-100">
                <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt="" /></a>
                <div class="card-body">
                  <h4 class="card-title">
                    <a href="#">{{result.item_name}}</a>
                  </h4>
                  <p class="card-text">{{result.description}}</p>
                  <button class="btn btn-success"><a class="text-white":href="`itemDetailsNew.php?itemid=${result._id}`" >More Details</a></button>
                </div>
                <div class="card-footer">
                  <small class="text-muted">Sold by: {{result.seller_name}}
                </div>
              </div>
            </div>

        </div>


      </section>


    </div>
  </body>
</html>

<script>
  const app = Vue.createApp({
    data() {
      return {
        count: 0,
        results: [],
        unfilteredResult: "",
        search: "",
        categories: ["All","Fruits","Vegetable","Meat","Dairy","Wheat"],
      };
    },

    methods:{

    },


    async mounted() {

      // Fetching from NEW items microservice
      try{
          var getItemUrl = "http://localhost:5001/items"
          
          var databaseitems = await fetch(getItemUrl)
          const databaseitemsJson = await databaseitems.json()

          if (databaseitems.status === 200){
            console.log(databaseitemsJson)
            // Get all the databases 
            this.results = databaseitemsJson.Success;
            this.unfilteredResult = databaseitemsJson.Success;
            console.log(this.results)

          }
          else{
            console.log("Database not connected")
          }
          }

          catch(error) {
            console.log(error)
          }




    },

    methods:{
      filterPosts(categoryName){
        console.log("hi")
        this.resetPosts()
        if (categoryName !== "All"){

          this.results = this.results.filter((result) => {
            // console.log(result.Category)
            return result.category === categoryName;
          })
        }

      },

      resetPosts(){
        this.results = this.unfilteredResult
      }
    },

    computed:{
      filterListings() {
        return this.results.filter(item => {
          return item.item_name.toLowerCase().match(this.search.toLowerCase());
        });
      }
    }
  });

  app.mount("#app");
</script>

<style></style>

<script
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
  crossorigin="anonymous"
></script>