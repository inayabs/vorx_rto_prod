<template>
  <div>
    <div class="row mb-3">
      <div class="col-md-12 pull-right text-right">
        <button class="btn btn-success" @click="sendMessage()">
          <i class="far fa-save"></i> Send Message
        </button>
      </div>
    </div>
    <div v-bind:class="'horizontal-line-wrapper-'+app_color+' mb-2'">
      <h6>SMS Create</h6>
    </div>
    <div class="clearfix"></div>
    <div class="form-padding-left-right">
      <div class="col-md-6">
        <div class="form-group">
          <label for="pnumber">Phone Number</label>
          <multiselect
            v-model="pnumbers"
            tag-placeholder="Add this as new number"
            placeholder="Include area code"
            label="name"
            track-by="code"
            :options="options"
            :multiple="true"
            :taggable="true"
            @tag="addTag"
          ></multiselect>
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          <label for="exampleFormControlTextarea1">Body</label>
          <textarea class="form-control" v-model="body" id="exampleFormControlTextarea1" rows="5"></textarea>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      app_color: app_color,
      pnumbers: [],
      body: "",
      options: []
    };
  },
  methods: {
    addTag(newTag) {
      const tag = {
        name: newTag,
        code: newTag
      };
      this.options.push(tag);
      this.pnumbers.push(tag);
    },
    sendMessage() {
      let data = {
        phone: this.pnumbers,
        body: this.body
      };

      const Toast = swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000
      });

      axios
        .post("/sms", data)
        .then(res => {
          Toast.fire({
            type: "success",
            title: res.data.message
          });
        })
        .catch(err => {
          Toast.fire({
            type: "error",
            title: err.response.data.message
          });
        });
    }
  }
};
</script>

<style>
</style>