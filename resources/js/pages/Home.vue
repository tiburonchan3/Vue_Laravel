<template>
  <div>
    <div id="carouselId" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#carouselId" data-slide-to="0" class="active"></li>
        <li data-target="#carouselId" data-slide-to="1"></li>
        <li data-target="#carouselId" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner" role="listbox">
        <div class="carousel-item active">
          <img src="/images/slide1.jpg" alt="First slide" id="Slide1" />
          <div class="carousel-caption d-none d-md-block">
            <h3>Title</h3>
            <p>Description</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="/images/slide2.jpg" alt="Second slide" id="Slide2" />
          <div class="carousel-caption d-none d-md-block">
            <h3>Title</h3>
            <p>Description</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="/images/slide3.jpg" alt="Third slide" id="Slide3" />
          <div class="carousel-caption d-none d-md-block">
            <h3>Title</h3>
            <p>Description</p>
          </div>
        </div>
      </div>
      <a
        class="carousel-control-prev"
        href="#carouselId"
        role="button"
        data-slide="prev"
      >
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a
        class="carousel-control-next"
        href="#carouselId"
        role="button"
        data-slide="next"
      >
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped>
#Slide1,
#Slide2,
#Slide3 {
  width: 100%;
  height: 500px;
}
</style>
