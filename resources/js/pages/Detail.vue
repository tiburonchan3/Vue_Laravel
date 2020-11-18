<template>
  <div class="card bg-dark text-white container p-3">
    <h5 class="card-title">{{ product.nombre }}</h5>
    <div class="row">
      <div class="col-md-6">
        <h3 class="lead mb-5">
          <span class="badge badge-success mb-3">${{ product.precio }}</span>
          <br />
          Tipo de comida: {{ product.tipo }}
        </h3>
        <button class="btn btn-success btn-sm mb-4" @click="addCart(product)">
          Ordenar
        </button>
        <h3 class="heading">Reviews</h3>
        <div class="review-rating">
          <div class="left-review">
            <div class="review-title">{{ totalrate }}</div>
            <div class="review-people">
              <i class="fa fa-user"></i> {{ totaluser }} total
            </div>
          </div>
          <div class="right-review">
            <div class="row-bar">
              <div class="left-bar">5</div>
              <div class="right-bar">
                <div class="bar-container">
                  <div
                    class="bar-5"
                    id="bar__5"
                    :style="'width:' + bar_5 + '%'"
                  ></div>
                </div>
              </div>
            </div>
            <div class="row-bar">
              <div class="left-bar">4</div>
              <div class="right-bar">
                <div class="bar-container">
                  <div class="bar-4" :style="'width:' + bar_4 + '%'"></div>
                </div>
              </div>
            </div>
            <div class="row-bar">
              <div class="left-bar">3</div>
              <div class="right-bar">
                <div class="bar-container">
                  <div class="bar-3" :style="'width:' + bar_3 + '%'"></div>
                </div>
              </div>
            </div>
            <div class="row-bar">
              <div class="left-bar">2</div>
              <div class="right-bar">
                <div class="bar-container">
                  <div class="bar-2" :style="'width:' + bar_2 + '%'"></div>
                </div>
              </div>
            </div>
            <div class="row-bar">
              <div class="left-bar">1</div>
              <div class="right-bar">
                <div class="bar-container">
                  <div class="bar-1" :style="'width:' + bar_1 + '%'"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="mt-5" v-if="!myRating.length">
          <p class="text-muted text-small">
            Puedes opinar acerca de este platillo
          </p>
          <star-rating
            :star-size="30"
            v-model="rating"
            :increment="0.5"
            text-class="custom-text"
          ></star-rating>
          <textarea
            placeholder="Escribe un comentario acerca de este producto"
            v-model="comment"
            name="comment"
            class="form-control mt-2 mb-2"
            id="comment"
            cols="4"
            rows="3"
          ></textarea>
          <button
            @click="setRating(product.id)"
            class="btn btn-primary btn-sm d-flex"
          >
            Votar
          </button>
        </div>
      </div>
      <div class="col-md-6">
        <img
          :src="'/images/productos/' + product.image"
          class="img-thumbnail"
          alt=""
        />
      </div>
    </div>
    <div>
      <p class="lead text-center text-white mt-3">
        Comentarios acerca del producto
      </p>
      <div class="row mb-3" v-for="comment in AllRating" :key="comment.id">
        <RatingItemComponent :rating="comment" />
      </div>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
//se importa el componente del carrito
import { ShowDetailEvent } from "../components/ProductItemComponent";
import RatingItemComponent from "../components/RatingItemComponent";
export const AddOnDetail = new Vue();
export default {
  components: {
    RatingItemComponent,
  },
  data() {
    return {
      product: {},
      totaluser: 0,
      totalrate: 0,
      //se inicializa el rating del producto
      rating: 0,
      //variable de comentario del rating
      comment: "",
      //obtiene el rating del usuario loggeado
      myRating: [],
      //obtiene todos los ratings del producto
      AllRating: [],
      bar_1: 0,
      bar_2: 0,
      bar_3: 0,
      bar_5: 0,
      bar_4: 0,
    };
  },
  methods: {
    addCart(prod) {
      this.detail = prod;
      AddOnDetail.$emit("add-on-detail", prod);
    },
    showDetail() {
      const params = this.$route.params;
      if (params) {
        axios.get("/producto/edit/" + params.id).then(({ data: datos }) => {
          this.product = datos.data;
        });
        this.ShowRating(params.id);
        this.MyRating(params.id);
      }
    },
    //metodo que obtiene el rating del producto seleccionado
    ShowRating(id) {
      //se envia por axios el id por post a laravel
      axios
        .post("/rating/all", { id: id })
        //respuesta de laravel
        .then(({ data: datos }) => {
          //la varaiable recibe el arreglo de datos
          this.AllRating = datos.data;
          this.totaluser = datos.data.length;
          let sum = 0;

          for (let i = 0; i < datos.data.length; i++) {
            sum += parseFloat(datos.data[i]["rating"]);
          }
          let avg = sum / datos.data.length;
          var bar1 = 0;
          var bar2 = 0;
          var bar3 = 0;
          var bar4 = 0;
          var bar5 = 0;
          if (avg > 0) {
            this.totalrate = parseFloat(sum.toFixed(1));
          } else {
            this.totalrate = 0;
          }
          for (let j = 0; j < datos.data.length; j++) {
            if (parseInt(datos.data[j]["rating"]) == "1") {
              bar1 += 1;
            }
            if (parseInt(datos.data[j]["rating"]) == "2") {
              bar2 += 1;
            }
            if (parseInt(datos.data[j]["rating"]) == "3") {
              bar3 += 1;
            }
            if (parseInt(datos.data[j]["rating"]) == "4") {
              bar4 += 1;
            }
            if (parseInt(datos.data[j]["rating"]) == "5") {
              bar5 += 1;
            }
          }
          this.bar_1 = bar1;
          this.bar_2 = bar2;
          this.bar_3 = bar3;
          this.bar_4 = bar4;
          this.bar_5 = bar5;
        })
        //en caso de error
        .catch((err) => {
          //se muestra el mensaje de error
          console.log("error en el servidor");
        });
    },
    MyRating(id) {
      //se envia un post con axios a laravel con el id del producto
      axios
        .post("/rating/show", { id: id })
        //respuesta de laravel
        .then(({ data: datos }) => {
          //la variable recibe el arreglo de datos
          this.myRating = datos.data;
        })
        //en caso de error
        .catch((err) => {
          //se muestra el mensaje de error
          console.log(err.response.data);
        });
    },
  },
  mounted() {
    this.showDetail();
  },
};
</script>

<style></style>
