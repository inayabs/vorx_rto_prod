<template>
  <div>
    <modal
      name="reply"
      transition="nice-modal-fade"
      classes="demo-modal-class"
      :min-width="200"
      :min-height="200"
      @before-open="beforeOpen"
      @before-close="beforeClose"
    >
      <div class="container pt-3">
        <div class="card">
          <div class="card-header">
            Message ID :
            <span>{{ currentmsg._id }}</span>
          </div>
          <div class="card-header">
            Recipients :
            <span>{{ currentmsg.originator }}</span>
          </div>
          <div class="card-body">
            <h5 class="card-title">Message:</h5>
            <textarea
              class="form-control mb-5"
              v-bind:name="newmessage.body"
              v-model="newmessage.body"
              rows="5"
            ></textarea>
            <a
              href="#"
              @click="sendMsg(currentmsg.originator)"
              class="btn btn-primary float-right"
            >Send</a>
          </div>
        </div>
      </div>
    </modal>
    <v-client-table
      :class="'header-'+app_color"
      :data="msglist"
      :columns="columns"
      :options="options"
    >
      <div slot="afterLimit" class="ml-2">
        <div class="btn-group">
          <a href="javascript:void(0)" @click="createMsg" class="btn btn-success" slot="afterLimit">
            <i class="fas fa-plus"></i> Create Message
          </a>
        </div>
      </div>
      <div class="type-wrapper" slot="type" slot-scope="{row}">
        <div v-if="row.direction == 'mt'" class="type-content">Sent</div>
        <div v-else class="type-content">Receieve</div>
      </div>
      <div class="recipients-wrapper" slot="recipients" slot-scope="{row}">
        <ul class="recipients-list">
          <li v-for="(item, index) in row.recipients.items" :key="index">{{ item.recipient }}</li>
        </ul>
        <!-- <pre>{{ row }}</pre> -->
      </div>
      <div class="btn-group" slot="actions" slot-scope="{row}" role="group">
        <button
          v-bind:class="'btn btn-'+app_color+' dropdown-toggle btn-sm'"
          type="button"
          id="dropdownMenu1"
          data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
        >Action</button>
        <ul
          class="dropdown-menu dropdown-menu-right multi-level"
          role="menu"
          aria-labelledby="dropdownMenu"
        >
          <li>
            <a class="dropdown-item" href="javascript:void(0)" @click="view(row)">
              <i class="fas fa-eye"></i> View
            </a>
          </li>
        </ul>
      </div>
    </v-client-table>
  </div>
</template>
<script>
const Toast = swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 3000
});
import moment from "moment";
export default {
  data() {
    return {
      msglist: [],
      app_color: app_color,
      currentmsg: {},
      newmessage: {
        recipient: "",
        body: ""
      },
      columns: ["type", "recipients", "originator", "body", "actions"],
      options: {
        // see the options API
      }
    };
  },
  created() {
    this.getList();
  },
  methods: {
    getList() {
      let vm = this;
      axios
        .get("/sms/list")
        .then(res => {
          vm.msglist = res.data.items;
        })
        .catch(err => {
          console.log(err);
        });
    },
    view(data) {
      console.log(data);
      let i = "";
      data.recipients.items.forEach(item => {
        i += `<li>${item.recipient}</li>`;
      });
      swal
        .fire({
          title: "Message Info",
          type: "info",
          html: `<div class="container mt-3">
        <div class="card">
          <div class="card-header text-left">
            Message ID : ${data._id}
          </div>
          <div class="card-header text-left">
            Originator : ${data.originator}
          </div>
          <div class="card-header text-left">
            Date Sent : ${moment(data.created_at).format(
              "DD/MM/YYYY hh:mm:ss a"
            )}
          </div>
           <div class="card-header text-left">
            Recipient : 
            <ul>${i}</ul>
          </div>
          <div class="card-body text-left">
            <h5 class="card-title">Message:</h5>
            <p>${data.body}</p>
          </div>
        </div>
      </div>`,
          showCloseButton: false,
          showCancelButton: true,
          heightAuto: false,
          width: "50%",
          focusConfirm: false,
          confirmButtonText: "Reply!",
          confirmButtonAriaLabel: "REPLY!"
        })
        .then(result => {
          console.log(result);
          if (result.value) {
            this.$modal.show("reply", { data: data });
          }
        });
    },
    createMsg() {
      window.location.href = "/sms/create";
    },
    sendMsg(recipient) {
      let vm = this;
      vm.newmessage.recipient = recipient;
      // console.log(vm.newmessage);
      axios
        .post("/sms/reply", vm.newmessage)
        .then(response => {
          console.log(response);
          Toast.fire({
            // position: 'top-end',
            type: "success",
            title: response.data.message,
            background: "#DCEDC8"
          });
        })
        .catch(error => {
          // console.log(error);
          Toast.fire({
            // position: 'top-end',
            type: "error",
            title: error.response.data.message,
            background: "#DCEDC8"
          });
        });
    },
    beforeOpen(event) {
      let vm = this;
      vm.currentmsg = event.params.data;
      // console.log(event);
    },
    beforeClose() {
      this.currentmsg = {};
      this.newmessage.recipient = "";
      this.newmessage.body = "";
      this.getList();
    }
  }
};
</script>

<style>
.v--modal-box.demo-modal-class {
  padding: 10px 0;
  height: auto !important;
}
.recipients-list {
  display: contents;
  list-style: none;
  margin: 0;
  padding: 0;
}
.recipients-list li {
  display: inline;
}
.recipients-list li:after {
  content: ", ";
}
.recipients-list li:last-child:after {
  content: "";
}
</style>