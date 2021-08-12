<template>
    <div>
        <div class="row no-gutters mb-2">
            <div class="col-md-12 text-center">
                <img class="is_logo" src="/images/logo/vorx_logo-colored.png" alt="">
            </div>
        </div>
        <setup-org />
    </div>
</template>
<script>
import SetupOrg from "./organisationComponent.vue";

export default {
  components: {
    SetupOrg,
  },
  data() {
    return {
      setup: window.setup ? 1 : null,
    };
  },
  created() {
  },
  methods: {
  },
};
</script>

<style scoped>
.is_logo {
    width: 20rem;
}
</style>