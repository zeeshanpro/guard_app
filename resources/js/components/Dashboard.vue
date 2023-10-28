<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">File Manager</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Starter Page</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="small-box"><button @click="openModal" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> Create Folder</button>
                <Modal ref="modal"></Modal>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0">Folders / Parent Folder</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover" style="border: none;" cellspacing="0" cellpadding="0">
                                <thead>
                                    <tr>
                                        <th width="5%"></th>
                                        <th width="85%">Name</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody style="">
                                    <tr v-for="folder in folders">
                                        <td></td>
                                        <td>
                                            <div class="folder" style=""><i class="fas fa-folder">&nbsp;&nbsp;{{ folder.name
                                            }}</i></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card card-danger card-outline">
                        <div class="card-header">
                            <h5 class="m-0">Recent uploaded</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover" style="border: none;" cellspacing="0" cellpadding="0">
                                <thead>
                                    <tr>
                                        <th width="5%"></th>
                                        <th width="85%">Name</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody style="">
                                    <tr v-for="folder in folders">
                                        <td></td>
                                        <td>
                                            <div class="folder" style=""><i class="fas fa-folder">&nbsp;&nbsp;{{ folder.name
                                            }}</i></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>
<script>
import axios from 'axios';

import Modal from './Modal.vue';

//import EventBus from '../event-bus';

const config = {
    headers: {
        'Content-Type': 'application/json',
    },
};

export default {
    data() {
        return {
            folders: [],
            files: []
        }
    },
    components: {
        Modal
    },
    methods: {
        async fetchData() {
            await axios.get('http://localhost:8000/api/getfolders', '', config)
                .then((response) => {
                    this.folders = response.data.data;

                    // Emit an event to notify other components that folders have been updated
                   //EventBus.$emit('folders-updated', this.folders);

                })
                .catch((error) => {
                    console.error('API Error:', error);
                });
        },
        openModal() {
            console.log('opennn modal');
            this.$refs.modal.openModal();
        }
    },
    mounted() {
        this.fetchData();
    },
}

</script>