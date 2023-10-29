<template>
  <div class="layout-panel">
    <div class="row mt-25 ml-20 mr-5">
      <q-breadcrumbs active-color="black">
        <template v-slot:separator>
          <q-icon size="1.2em" name="chevron_right"></q-icon>
        </template>
        <q-breadcrumbs-el
          v-for="(breadcrumb, index) in currentBreadcrumbs"
          :key="index"
          :label="breadcrumb.name"
          :to="breadcrumb.path"
          @click="handleBreadcrumbClick(index)"
        >
        </q-breadcrumbs-el>
      </q-breadcrumbs>

      <q-space class="col-1" />
      <q-input
        outlined
        v-model="searchText"
        debounce="500"
        dense
        placeholder="Search by name"
        class="search-field col-3"
        no-error-icon
      >
        <template v-slot:prepend>
          <MagnifyingGlass class="glass-icon" />
        </template>
      </q-input>
    </div>
    <div
      v-if="filteredFiles.length === 0"
      class="flex no-data-available justify-center items-center mt-25 ml-20 mr-20"
    >
      <no-data-available
        :heading="heading"
        :description="description"
        :title="'automation'"
      />
    </div>
    <div v-else class="mt-25 ml-25 row">
      <q-card
        flat
        class="my-card text-center"
        v-for="item in filteredFiles"
        :key="item.name"
      >
        <div v-if="item.type == 'file'" class="download-icon-style">
          <span class="icon-style">
            <a :href="item.link">
              <app-icons icon="downloadFile" />
            </a>
          </span>
        </div>

        <div
          :class="item.type == 'folder' ? 'mt-15' : ''"
          @click="item.type == 'folder' ? navigateTo(item) : ''"
        >
          <app-icons :icon="item.type" />
          <q-item-label class="fs-14 fw-400">{{ item.name }}</q-item-label>
          <q-item-label class="fs-14 fw-400 text-color">{{
            item.type == "folder" ? item.count + " items" : item.size
          }}</q-item-label>
        </div>
      </q-card>
    </div>
  </div>
</template>
 
<script>
import { mapState } from "vuex";
import { Loading } from "quasar";

export default {
  data() {
    return {
      currentPath: [],
      currentFolder: null,
      searchText: "",
      heading: "No Folder/File Is Available",
      description:
        "Currently, there are no folders or files available in this view. <br>To view or download specific files, first generate files accordingly.",
    };
  },
  computed: {
    ...mapState({
      getFiles: (state) => state.workspaceReporting.getFiles,
    }),
    filteredFiles() {
      return this.getFiles.filter((item) =>
        item.name.toLowerCase().includes(this.searchText.toLowerCase())
      );
    },
    currentBreadcrumbs() {
      const breadcrumbs = [
        {
          name: "All Reports",
          path: `/workspace/${this.$route.params.id}/view-reports/AllReports`,
        },
      ];

      let currentPathSoFar = "";
      for (const segment of this.currentPath) {
        currentPathSoFar += `/${segment}`;
        breadcrumbs.push({
          name: segment,
          path: `/workspace/${this.$route.params.id}/view-reports/AllReports${currentPathSoFar}`,
        });
      }

      return breadcrumbs;
    },
  },
  methods: {
    navigateTo(folder) {
      if (folder.type === "file") {
        console.log("Opening file:", folder.name);
      } else {
        this.currentPath.push(folder.name);
        this.currentFolder = folder;
        this.$router.push(
          `/workspace/${
            this.$route.params.id
          }/view-reports/AllReports/${this.currentPath.join("/")}`
        );
        this.getReports(this.currentPath.join("/"));
      }
    },
    handleBreadcrumbClick(index) {
      const clickedSegment = this.currentBreadcrumbs[index];
      if (clickedSegment) {
        const newPath = this.currentBreadcrumbs
          .slice(1, index + 1)
          .map((breadcrumb) => breadcrumb.name);
        this.currentPath = newPath;
        this.$router.push(
          `/workspace/${
            this.$route.params.id
          }/view-reports/${this.currentPath.join("/")}`
        );
        this.getReports(this.currentPath.join("/"));
        this.currentBreadcrumbs = this.currentBreadcrumbs.slice(0, index + 1);
      }
    },
    getReports(path) {
      Loading.show({
        spinnerSize: 30,
      });
      const payload = {
        workspace: this.dashboard.selectedPanel,
        path: path,
      };
      this.$store
        .dispatch("workspaceReporting/getReports", payload)
        .then(() => {
          Loading.hide();
          this.searchText = "";
        })
        .catch(() => {
          Loading.hide();
        });
    },
  },
  created() {
    this.getReports();
  },
};
</script>

<style scoped>
.search-field:deep(.q-field__control::before),
.search-field:deep(.q-field__control::after) {
  border: 1px solid var(--q-light-grey-border) !important;
  border-radius: 7px !important;
  height: 32px !important;
}

.search-field {
  padding: 0 15px !important;
}

.glass-icon {
  transform: translateY(-3px);
}
:deep(.q-field--dense .q-field__control, .q-field--dense .q-field__marginal) {
  height: 33px !important;
}

.my-card {
  width: 170px !important;
  height: 139px !important;
  border: 1px solid var(--q-lighter-grey-border) !important;
  border-radius: 0px !important;
  margin-right: 8px !important;
  margin-top: 10px !important;
}

.text-color {
  color: var(--q-grey-icon-color);
}

.download-icon-style {
  text-align: right;
  margin-top: 5px;
  margin-right: 10px;
  height: 15px;
}

.icon-style {
  cursor: pointer;
}
</style>