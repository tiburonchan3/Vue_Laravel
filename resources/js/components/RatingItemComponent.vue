<template>
  <div>
    <div class="col-md-1">
      <img
        :src="'/images/usuarios/' + rating.avatar"
        class="rounded-circle"
        alt="no-image"
        width="50"
        height="50"
      />
    </div>
    <div class="col-md-11 pl-3 rating">
      <p class="text-info">
        {{ rating.user }}
        <star-rating
          :star-size="15"
          :read-only="true"
          :rating="rating.rating"
        ></star-rating>
      </p>

      <p class="text-justify text-white text-small">
        {{ rating.comment }}
      </p>
    </div>
    <hr />
  </div>
</template>

<script>
export default {
  props: {
    rating: Object,
  },
};
</script>

<style lang="scss" scoped>
</style>
