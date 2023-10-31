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
                <Modal ref="modal" :callMethod="fetchData"></Modal>
                </div>

                <div class="small-box">
                    <input type="file" ref="fileInput" @change="handleFileChange" style="display: none;">
                    <button @click="openDialog" type="button" class="btn btn-primary"><i class="fa fa-upload"></i> Upload File</button>    
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-danger card-outline">
                        <div class="card-header">
                            <h5 class="m-0">Folders /  <router-link to="/admin/files">Parent Folder</router-link></h5>
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
                                    <tr v-for="file in files">
                                        <td></td>
                                        <td>
                                            <div class="folder" style=""><i class="fa fa-file">&nbsp;&nbsp;{{ file.name
                                            }}</i></div>
                                        </td>
                                        <td><i @click="deleteFile(file.id)" class="fa fa-trash" aria-hidden="true"></i></td>
                                    </tr>
                                    <tr v-for="folder in folders">
                                        <td></td>
                                        <td>
                                            <div class="folder" style="">
                                                <router-link :to="{name: 'FileList', params: {id: folder.id}}">
                                                    <i class="fas fa-folder">&nbsp;&nbsp;{{ folder.name}}</i>
                                                </router-link>
                                            </div>
                                        </td>
                                        <td><i @click="deleteFolder(folder.id)" class="fa fa-trash" aria-hidden="true"></i></td>

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

    const config = {
        headers: {
            'Content-Type': 'application/json',
        },
    };

    export default {
        data(){
            return {
                files: [],
                folders: []
            }
        },
        components: {
            Modal
        },
        created: function(){
            this.fetchData();
        },
        methods:{
            
        async fetchData() {
            await axios.get('http://localhost:8000/api/getfiles/'+this.$route.params.id , config)
                .then((response) => {
                    console.log(response);
                    this.files = response.data.files;
                    this.folders = response.data.folders;
                })
                .catch((error) => {
                    console.error('API Error:', error);
                });
        },
        async deleteFolder(id) {
            await axios.delete('http://localhost:8000/api/folders/'+id, '', config)
                .then((response) => {
                    console.log(response);
                    this.fetchData();
                    // this.folders = response.data.data;
                })
                .catch((error) => {
                    console.error('API Error:', error);
                });
        },
        async deleteFile(id) {
            await axios.delete('http://localhost:8000/api/files/'+id, '', config)
                .then((response) => {
                    console.log(response);
                    this.fetchData();
                    // this.folders = response.data.data;
                })
                .catch((error) => {
                    console.error('API Error:', error);
                });
        },
        openModal() {
            this.$refs.modal.openModal();
        },
        handleFileChange(event){
            const file = event.target.files[0];
            const formData = new FormData();
            formData.append('file', file);
            formData.append('folder_id',this.$route.params.id)
            try{
                const {data} = axios.post('http://localhost:8000/api/file/upload/',formData);
                this.fetchData();
            }catch(error){
                console.log(error);
            }
        },
        openDialog(){
            const elem = this.$refs.fileInput;
            elem.click();
        },
        }

    }
</script>
<style scoped>
.small-box {
    margin-left: 20px;
}

</style>