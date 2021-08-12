<template>
  <div>
    <div class="accordion" id="accordionExample">
      <div v-for="(unit, index) in extra_units" :key="unit.id" class="card burukotoy">
        <div class="card-header" :id="`#unit_heading_${index}`">
          <h2 class="mb-0">
            <button
              class="btn btn-link"
              type="button"
              data-toggle="collapse"
              :data-target="`#unit_${unit.id}`"
              :aria-expanded="index == 0 ? 'true' : 'false'"
              :aria-controls="`unit_${unit.id}`"
            >
              {{ unit_name(index) }}
              <span v-if="unit.soa_num != undefined ">( {{ unit.soa_num }} )</span>
            </button>
          </h2>
        </div>
        <div
          :id="`unit_${unit.id}`"
          :class="{'show' : index == 0 , 'collapse' : index != 0}"
          :aria-labelledby="`#unit_heading_${unit.id}`"
          data-parent="#accordionExample"
        >
          <div class="card-body">
            <extra-unit-detail
              v-on="$listeners"
              :edit_id="edit_id"
              :edit_status="edit_status"
              :extra_unit="unit"
            ></extra-unit-detail>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style>
.burukotoy {
  overflow: visible !important;
}
</style>
<script>
import extraUnitDetail from "./ExtraUnitDetailComponent.vue";
export default {
  components: {
    extraUnitDetail
  },
  props: ["extra_units", "edit_id", "edit_status"],
  methods: {
    unit_name(index) {
      let unitHandler = this.extra_units[index].units;
      let unitname = [];
      unitHandler.forEach(element => {
        unitname.push(element.code);
      });
      return unitname.toString();
    }
  }
};
</script>