<template>
    <v-container>
        <v-row>
            <v-col sm="12" v-if="userInfo.is_admin === 1">
                <v-spacer></v-spacer>
                <v-btn color="primary" @click="openCreateDialog">
                    +Add Product
                </v-btn>
            </v-col>
            <v-col v-if="requiredProductList.length === 0" sm="12">
                <h3>No Products to Display</h3>
            </v-col>
            <v-col v-else sm="12" md="4" lg="3" v-for="(product, key) in requiredProductList" :key="key">
                <v-card>
                    <v-card-text>
                        <v-card-title>
                            {{ product.name }}
                            <span v-if="product.status !== 1"> (Disabled) </span>
                        </v-card-title>
                        <v-img
                            v-if="product.image_path"
                            height="200"
                            width="200"
                            class="mx-auto"
                            :src="'storage/'+product.image_path"
                        ></v-img>
                        <br>
                        <span v-if="product.description"><b>Description: </b>{{product.description}}<br></span>
                        <span><b>Price: </b> {{product.price}}<br></span>
                        <span v-if="product.discount">
                            <b>Discount: </b> {{product.discount}} % <br>
                            <b>Final Price: </b> {{product.price - (product.price*(product.discount/100))}}
                        </span>
                    </v-card-text>
                    <v-card-actions class="white--text" v-if="userInfo.is_admin === 1">
                        <v-btn small class="white--text" color="red" @click="deleteProduct(product)">
                            Delete
                        </v-btn>
                        <v-btn small color="primary" @click="openEditDialog(product)">
                            Edit
                        </v-btn>
                        <v-btn small color="primary" v-if="product.status === 1" @click="toggleDisable(product)">
                            Disable
                        </v-btn>
                        <v-btn small color="primary" v-else @click="toggleDisable(product)">
                            Enable
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
        <v-pagination
            v-model="page"
            :length="pageCount"
            class="mx-auto"
            @input="getProductList"
        ></v-pagination>
        <v-dialog
            v-model="editDialogShow"
            scrollable
            :overlay="false"
            max-width="600px"
            transition="dialog-transition"
        >
            <v-card>
                <v-card-text>
                    <v-card-title>
                        Edit Product
                    </v-card-title>
                    <v-form @submit.prevent="updateProduct" width="100%" data-vv-scope="edit" id="updateProduct">
                        <v-row>
                            <v-col sm="12">
                                <v-text-field
                                    v-model="selectedProduct.name"
                                    label="Name"
                                    name="name"
                                    color="primary"
                                    v-validate="'required'"
                                    :error-messages="errors.collect('edit.name')"
                                ></v-text-field>
                            </v-col>
                            <v-col sm="12">
                                <v-text-field
                                    v-model="selectedProduct.price"
                                    label="Price"
                                    name="price"
                                    color="primary"
                                    v-validate="'required'"
                                    :error-messages="errors.collect('edit.price')"
                                ></v-text-field>
                            </v-col>
                            <v-col sm="12">
                                <v-text-field
                                    v-model="selectedProduct.discount"
                                    label="Discount"
                                    name="discount"
                                    color="primary"
                                    :error-messages="errors.collect('edit.discount')"
                                ></v-text-field>
                            </v-col>
                            <v-col sm="12">
                                <v-text-field
                                    v-model="selectedProduct.description"
                                    label="Description"
                                    name="description"
                                    color="primary"
                                    :error-messages="errors.collect('edit.description')"
                                ></v-text-field>
                            </v-col>
                            <v-col sm="12">
                                <input
                                    type="file"
                                    name="image"
                                    accept="image/*"
                                >
                            </v-col>
                            <v-btn color="primary" type="submit" :loading="createLoading" :disabled="createLoading">Save</v-btn>
                        </v-row>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-dialog>
        <v-dialog
            v-model="createDialogShow"
            scrollable
            :overlay="false"
            max-width="600px"
            transition="dialog-transition"
        >
            <v-card>
                <v-card-text>
                    <v-card-title>
                        Add Product
                    </v-card-title>
                    <v-form @submit.prevent="addProduct" width="100%" data-vv-scope="new" id="newProduct">
                        <v-row>
                            <v-col sm="12">
                                <v-text-field
                                    v-model="newProduct.name"
                                    label="Name"
                                    name="name"
                                    color="primary"
                                    v-validate="'required'"
                                    :error-messages="errors.collect('new.name')"
                                ></v-text-field>
                            </v-col>
                            <v-col sm="12">
                                <v-text-field
                                    v-model="newProduct.price"
                                    label="Price"
                                    name="price"
                                    type="number"
                                    color="primary"
                                    v-validate="'required|numeric'"
                                    :error-messages="errors.collect('new.price')"
                                ></v-text-field>
                            </v-col>
                            <v-col sm="12">
                                <v-text-field
                                    v-model="newProduct.discount"
                                    label="Discount"
                                    name="discount"
                                    color="primary"
                                    :error-messages="errors.collect('new.discount')"
                                ></v-text-field>
                            </v-col>
                            <v-col sm="12">
                                <v-text-field
                                    v-model="newProduct.description"
                                    label="Description"
                                    name="description"
                                    color="primary"
                                    :error-messages="errors.collect('new.description')"
                                ></v-text-field>
                            </v-col>
                            <v-col sm="12">
                                <input
                                    type="file"
                                    name="image"
                                    accept="image/*"
                                >
                            </v-col>
                            <v-btn color="primary" type="submit" :loading="createLoading" :disabled="createLoading">Save</v-btn>
                        </v-row>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>
    import {mapGetters} from 'vuex'
    export default {
        name: "ProductList",
        computed: {
            ...mapGetters([
                'userInfo'
            ]),
            requiredProductList() {
                if(this.userInfo.is_admin) {
                    return this.productList
                } else {
                    return this.productList.filter((product) => product.status === 1)
                }
            },
            pageCount() {
                return Math.ceil(this.totalProducts/5)
            }
        },
        methods: {
            deleteProduct(product) {
                axios.get(`/api/products/${product.id}/delete`)
                    .then((response) => {
                        this.getProductList()
                    }).catch((error)=>{
                    console.log(error);
                });
            },
            toggleDisable(product) {
                axios.get(`/api/products/${product.id}/disable`)
                    .then((response) => {
                        product.status = product.status ? 0 : 1
                    }).catch((error)=>{
                    console.log(error);
                });
            },
            openCreateDialog(product) {
                this.newProduct = {}
                this.createDialogShow = true
            },
            openEditDialog(product) {
                this.selectedProduct = Object.assign({}, product)
                this.editDialogShow = true
            },
            getProductList(number) {
                this.pageNo = number;
                let paginationObject = {
                    rowsPerPage: 5,
                    totalItems: this.totalProducts,
                    page: this.pageNo
                }
                axios.get(`/api/products`, {params: paginationObject})
                    .then((response) => {
                        this.productList = response.data.data.data
                        this.totalProducts = response.data.data.total
                    }).catch((error)=>{
                    console.log(error);
                });
            },
            updateProduct() {
                let updateForm = document.getElementById("updateProduct");
                let formData = new FormData(updateForm);
                axios
                    .post(
                        `/api/products/` +
                        this.selectedProduct.id+'/update',
                        formData
                    )
                    .then(response => {
                        this.getProductList()
                        this.editDialogShow = false
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            addProduct() {
                this.createLoading = true
                let addForm = document.getElementById("newProduct");
                let formData = new FormData(addForm);
                axios
                    .post(
                        `/api/products`,
                        formData
                    )
                    .then(response => {
                        this.getProductList()
                        this.createDialogShow = false
                    })
                    .catch(error => {
                        console.log(error);
                    })
                    .finally(() => {
                        this.createLoading = false
                    })
            }
        },
        data() {
            return {
                createLoading: false,
                newProduct: {},
                editDialogShow: false,
                createDialogShow: false,
                productList: [],
                totalProducts: 0,
                page: 1,
                selectedProduct: {},
                deleteId: '',
                disableId: ''
            }
        },
        mounted() {
            this.getProductList()
        }
    }
</script>

<style scoped>

</style>
