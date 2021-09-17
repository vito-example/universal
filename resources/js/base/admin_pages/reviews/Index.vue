<template>
  <el-table
      :data="reviews"
      border
      style="width: 100%">
    <el-table-column
        prop="date"
        label="მომხმარებელი"
        width="200"
    >
      <template v-slot="scope">
        {{ scope?.row?.user?.full_name }}
      </template>
    </el-table-column>
    <el-table-column
        label="ტრენინგი"
        width="300"
    >
      <template v-slot="scope">
        {{ scope?.row?.model?.title }}
      </template>
    </el-table-column>
    <el-table-column
        prop="value"
        label="შეფასება"
        width="120"
    >
    </el-table-column>
    <el-table-column
        prop="content"
        label="კომენტარი">
    </el-table-column>
    <el-table-column
        label="მოქმედება"
        width="130"
    >
      <template v-slot="scope">
        <el-button
            type="success"
            icon="el-icon-check"
            circle
            :disabled="scope.row.status === 200"
            @click="onSetStatus(scope.row.id, 200)"
        ></el-button>
        <el-button
            type="danger"
            icon="el-icon-close"
            circle
            :disabled="scope.row.status === 300"
            @click="onSetStatus(scope.row.id, 300)"
        ></el-button>
      </template>
    </el-table-column>
  </el-table>
</template>

<script>
import {getData} from "@/base/mixins/getData";
import {responseParse} from "@/base/mixins/responseParse";

export default {
  props: {
    reviews: {
      type: Array
    },

    updateRoute: {
      type: String
    }
  },

  data() {
    return {
      tableData: []
    }
  },

  methods: {
    async onSetStatus (id, status) {
      await getData({
        method: 'POST',
        url: this.updateRoute,
        data: {
          review_id: id,
          status
        }
      }).then(response => {
        if (response.status === 200) {
          this.$notify({
            title: 'სტატუსი',
            message: 'წარმატებით შეიცვალა',
            type: 'success'
          });

          setTimeout(() => {
            window.location.reload();
          }, 500);
        }
      })
    }
  }
}
</script>