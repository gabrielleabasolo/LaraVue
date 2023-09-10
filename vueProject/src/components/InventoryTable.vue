<template>
  <div>
    <Button color="green" @click="showAddModal" class="mx-auto"
          >Add</Button
        >
  </div>

  <Table>
    <table-head>
      <table-head-cell>Product ID</table-head-cell>
      <table-head-cell>Supply</table-head-cell>
      <table-head-cell>Item Name</table-head-cell>
      <table-head-cell>Created at</table-head-cell>
      <table-head-cell><span class="sr-only">Edit</span></table-head-cell>
    </table-head>
    <table-body>
      <table-row v-for="item in data">
        <table-cell>{{ item.id }}</table-cell>
        <table-cell>{{ item.Supply }}</table-cell>
        <table-cell>{{ item.Item_Name }}</table-cell>
        <table-cell>{{ item.created_at }}</table-cell>
        <table-cell>
          <button-group>
            <Button color="blue" @click="setSelectedItem(item, 'edit')">Edit</Button>
            <Button color="red" @click="setSelectedItem(item, 'delete')"
              >Delete</Button
            >
          </button-group>
        </table-cell>
      </table-row>
    </table-body>
  </Table>

  <!-- todo create modal for add -->
  <Modal size="md" v-if="isShowAddModal" @close="closeAddModal">
    <template #header>
      <div class="flex items-center text-lg">
        Add Item
      </div>
    </template>
    <template #body>
      <div  class="flex flex-col">
        <Input v-model="supplyInput" placeholder="Add Supply" type="number"   label="Add Supply" class="pb-4"/>
        <Input v-model="itemNameInput" placeholder="Add Item" label="Add item name" />
      </div>
    </template>
    <template #footer>
      <div class="flex justify-between">
        <Button color="light" @click="closeAddModal" class="mx-auto"
          >Cancel</Button
        >
        <Button
          color="green"
          @click="AddItemHandler()"
          class="mx-auto"
          >Add</Button
        >
      </div>
    </template>
  </Modal>
  <!-- end for add modal -->

  <!-- todo create modal for edit -->
  <Modal size="md" v-if="isShowEditModal" @close="closeEditModal">
    <template #header>
      <div class="flex items-center text-lg">
        Edit Item
      </div>
    </template>
    <template #body>
      <div  class="flex flex-col">
        <Input v-model="supplyInput" type="number"   label="Edit Supply" class="pb-4"/>
        <Input v-model="itemNameInput" label="Edit item name" />
      </div>
    </template>
    <template #footer>
      <div class="flex justify-between">
        <Button color="light" @click="closeEditModal" class="mx-auto"
          >Cancel</Button
        >
        <Button
          color="green"
          @click="editItemHandler()"
          class="mx-auto"
          >Edit</Button
        >
      </div>
    </template>
  </Modal>
  <!-- end for edit modal -->

  <!-- todo create modal for delete -->
  <Modal size="xs" v-if="isShowDeleteModal" @close="closeDeleteModal">
    <template #header>
      <div class="flex items-center text-lg">
        Are you sure you want to delete?
      </div>
    </template>
    <template #body>
      <div class="flex justify-between">
        <Button color="light" @click="closeDeleteModal" class="mx-auto"
          >Cancel</Button
        >
        <Button
          color="red"
          @click="deleteItemHandler(selecteditem?.id ?? 0)"
          class="mx-auto"
          >Delete</Button
        >
      </div>
    </template>
  </Modal>
</template>

<script setup lang="ts">
import { ref } from "vue";

import {
  Table,
  TableHead,
  TableBody,
  TableHeadCell,
  TableRow,
  TableCell,
  ButtonGroup,
  Button,
  Modal,
  Input,
} from "flowbite-vue";



type Inventory = {
  id: number;
  Supply: number;
  Item_Name: string;
  created_at: string;
};
const selecteditem = ref<Inventory>();
const data = ref<Inventory[]>([]);
const message = ref("");

const supplyInput = ref();
const itemNameInput = ref();

function clearInput(){
  supplyInput.value = null;
  itemNameInput.value = "";
}

const getData = async () => {
  const response = await fetch("http://localhost:8000/api/InventoryList/");
  const results = await response.json();
  data.value = results.items;
  message.value = results.message;
};

getData();

const deleteItemHandler = async (id: number) => {
  console.log(id);
  const request = await fetch(`http://localhost:8000/api/InventoryList/delete/${id}`);
  const results = await request.json();
  message.value = results.message;
  console.log(message.value);
  await getData();
  closeDeleteModal();
};

const editItemHandler = async () => {
  const updatedInfo: Inventory = {
    id: selecteditem.value?.id ?? 0,
    Supply: supplyInput.value,
    Item_Name: itemNameInput.value,
    created_at: selecteditem.value?.created_at ?? "",
  }
  //${selecteditem.value?.id}
  const request = await fetch(`http://localhost:8000/api/InventoryList/update` , {
    headers: {"Content-Type" : "application/json"},
    mode: "cors",
    method: 'PUT',
    body: JSON.stringify(updatedInfo),
  }).then(response => response.json());

  //const response = await request.json();
  console.log(updatedInfo);
  console.log(request);
  console.log(selecteditem);
  await getData();
  clearInput();
  closeEditModal();
};


//for edit modal

const isShowEditModal = ref(false);
function closeEditModal() {
  isShowEditModal.value = false;
  clearInput();
}

function showEditModal() {
  isShowEditModal.value = true;
}

//for delete modal
const isShowDeleteModal = ref(false);
function closeDeleteModal() {
  isShowDeleteModal.value = false;
}

function showdeleteModal() {
  isShowDeleteModal.value = true;
}

function setSelectedItem(item:Inventory, method:'edit'|'delete') {
  if(method === 'delete' && item !== undefined){
    selecteditem.value = item;
    showdeleteModal();
  }else if(method === 'edit' && item !== undefined){
    selecteditem.value = item;
    supplyInput.value = selecteditem.value.Supply;
    itemNameInput.value = selecteditem.value.Item_Name;
    console.log(item);
    console.log(selecteditem);
    showEditModal();
  }  
}
// Todo: Add Modal
const isShowAddModal = ref(false);
function closeAddModal() {
  isShowAddModal.value = false;
}

function showAddModal() {
  isShowAddModal.value = true;
}

const AddItemHandler = async () => {
  const updatedInfo: Inventory = {
    id: selecteditem.value?.id ?? 0,
    Supply: supplyInput.value,
    Item_Name: itemNameInput.value,
    created_at: selecteditem.value?.created_at ?? "",
  }
  const request = await fetch(`http://localhost:8000/api/InventoryList/Add`, {
    headers: {"Content-Type" : "application/json"},
    mode: "cors",
    method: 'POST',
    body: JSON.stringify(updatedInfo),
  });
  const results = await request.json();
  message.value = results.message;
  await getData();
  closeAddModal();
};

</script>
