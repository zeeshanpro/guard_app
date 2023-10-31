<template>
    <div v-if="showModal" class="modal">
        <div class="modal-dialog">
      <div class="modal-content">
        
        <span @click="closeModal" class="close">&times;</span>
        <h2>Creat Folder</h2>
        <input v-model="inputValue" type="text" placeholder="Enter something">
        <button @click="submitModal">Submit</button>
    </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';

  //import Dashboard from './Dashboard.vue';
 // import {EventBus} from '../event-bus';

  const config = {
    headers: {
        'Content-Type': 'application/json',
    },
  };
  export default {
    data() {
      return {
        showModal: false,
        inputValue: "",
        folders: []
      };
    },
    props: {
      callMethod: ""
    },
    methods: {
      openModal() {
        this.showModal = true;
      },
      closeModal() {
        this.showModal = false;
        this.inputValue = ""; // Clear the input field when closing the modal
      },
      async submitModal() {
        // Handle the input value or perform other actions
        // alert("You entered: " + this.inputValue);
        await axios.post('http://localhost:8000/api/folders', {'folder_name': this.inputValue, 'parent_folder': this.$route.params.id}, config)
        .then((response) => {
            console.log(response.data);
            this.callMethod();

        })
        .catch((error) => {
            console.error('API Error:', error);
        });
        this.closeModal();
      }
    },
    // created() {
    //     // Listen for the "folders-updated" event to trigger a refresh
    //     // EventBus.$on('folders-updated', (folders) => {
    //     // this.folders = folders;
    //     // });

    //     this.$emitter.on('folders-updated', (folders) => {
    //     // Call the method in this component
    //     this.folders = folders;
    //     });

    //     // Fetch the initial list of folders
    //     this.fetchData();
    // },
  };
  </script>
  
  <style scoped>
  /* Add your CSS styles for the modal here */
  .modal {
    display: block;
    /* Other modal styles */
  }
  
  .modal-content {
    /* Styles for the modal content */
  }
  
  .close {
    /* Styles for the close button */
  }
  </style>
  