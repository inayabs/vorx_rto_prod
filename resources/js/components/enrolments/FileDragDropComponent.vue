<template>
    <div id="file-drag-drop">
      <div class="row">
        <div class="col-md-12">
          <form id="dropzone" ref="fileform">
              <span class="drop-files">Drop the files here!</span>
          </form>
          <!-- <a class="submit-button" v-on:click="submitFiles()" v-show="files.length > 0">UPLOAD</a> -->
        </div>
      </div>
      <div class="row">
        <div v-for="(file, key) in files" class="col-md-6 file-listing" v-bind:key='file.id'>
              <div class="remove-container">
                <a class="btn btn-danger btn-sm remove" v-on:click="removeFile( key )"><i class="fa fa-times" aria-hidden="true"></i></a>
              </div>
              <div class="col-md-12"><img class="preview" v-bind:ref="'preview'+parseInt( key )"/></div>
              <div class="col-md-12">{{ file.name | limitText}}</div>
              
              <!-- {{ file.name }} -->
              <!-- <progress max="100" :value.prop="uploadPercentage"></progress> -->
        </div>
      </div>
    </div>
</template>
 
<script>
  export default {
    components: {
     
    },
    props: {
      uploadURL: '',

    },
    mounted() {
      // console.log(this.uploadURL);
       /*
        Determine if drag and drop functionality is capable in the browser
      */
      this.dragAndDropCapable = this.determineDragAndDropCapable();

      /*
        If drag and drop capable, then we continue to bind events to our elements.
      */
      if( this.dragAndDropCapable ){
        /*
          Listen to all of the drag events and bind an event listener to each
          for the fileform.
        */
        ['drag', 'dragstart', 'dragend', 'dragover', 'dragenter', 'dragleave', 'drop'].forEach( function( evt ) {
          /*
            For each event add an event listener that prevents the default action
            (opening the file in the browser) and stop the propagation of the event (so
            no other elements open the file in the browser)
          */
          this.$refs.fileform.addEventListener(evt, function(e){
            e.preventDefault();
            e.stopPropagation();
          }.bind(this), false);
        }.bind(this));

        /*
          Add an event listener for drop to the form
        */
        this.$refs.fileform.addEventListener('drop', function(e){
          /*
            Capture the files from the drop event and add them to our local files
            array.
          */
          for( let i = 0; i < e.dataTransfer.files.length; i++ ){
            this.files.push( e.dataTransfer.files[i] );
            this.getImagePreviews();
          }
        }.bind(this));
      }
      console.log('end');
    },
    data () {
      return {
        dragAndDropCapable: false,
        files: [],
        uploadPercentage: 0,
        // uploadURL: '',
      }
    },
    methods: {
      /*
        Determines if the drag and drop functionality is in the
        window
      */
      determineDragAndDropCapable(){
        /*
          Create a test element to see if certain events
          are present that let us do drag and drop.
        */
        var div = document.createElement('div');

        /*
          Check to see if the `draggable` event is in the element
          or the `ondragstart` and `ondrop` events are in the element. If
          they are, then we have what we need for dragging and dropping files.

          We also check to see if the window has `FormData` and `FileReader` objects
          present so we can do our AJAX uploading
        */
        return ( ( 'draggable' in div )
                || ( 'ondragstart' in div && 'ondrop' in div ) )
                && 'FormData' in window
                && 'FileReader' in window;
      },
      /*
        Gets the image preview for the file.
      */
      getImagePreviews(){
        /*
          Iterate over all of the files and generate an image preview for each one.
        */
        for( let i = 0; i < this.files.length; i++ ){
          /*
            Ensure the file is an image file
          */
          if ( /\.(jpe?g|png|gif)$/i.test( this.files[i].name ) ) {
            /*
              Create a new FileReader object
            */
            let reader = new FileReader();

            /*
              Add an event listener for when the file has been loaded
              to update the src on the file preview.
            */
            reader.addEventListener("load", function(){
              this.$refs['preview'+parseInt( i )][0].src = reader.result;
            }.bind(this), false);

            /*
              Read the data for the file in through the reader. When it has
              been loaded, we listen to the event propagated and set the image
              src to what was loaded from the reader.
            */
            reader.readAsDataURL( this.files[i] );
          }else{
            /*
              We do the next tick so the reference is bound and we can access it.
            */
          //  console.log(this.files[i].name);
           let fileName = this.files[i].name;
            this.$nextTick(function(){
              this.$refs['preview'+parseInt( i )][0].src = '/images/pdf.png';

              switch(fileName.split('.').pop()) {
                case 'pdf':
                  this.$refs['preview'+parseInt( i )][0].src = '/storage/images/pdf.png';
                  break;
                case 'doc':
                  this.$refs['preview'+parseInt( i )][0].src = '/storage/images/docs.png';
                  // code block
                  break;
                case 'docx':
                  this.$refs['preview'+parseInt( i )][0].src = '/storage/images/docs.png';
                  // code block
                  break;
                default:
                  this.$refs['preview'+parseInt( i )][0].src = '/storage/images/attachment.png';
                  // code block
              }

            });
          }
        }
      },

      /*
        Removes a select file the user has uploaded
      */
      removeFile( key ){
        this.files.splice( key, 1 );
      },

      /*
        Submits the files to the server
      */
      submitFiles(){
        // console.log(this.files);
        /*
          Initialize the form data
        */
        let formData = new FormData();

        /*
          Iteate over any file sent over appending the files
          to the form data.
        */
        for( var i = 0; i < this.files.length; i++ ){
          let file = this.files[i];

          formData.append('files[' + i + ']', file);
        }

        // console.log(formData);

        /*
          Make the request to the POST /file-drag-drop URL
        */
        axios.post( this.uploadURL,
          formData,
          {
            headers: {
                'Content-Type': 'multipart/form-data'
            },
            onUploadProgress: function( progressEvent ) {
              this.uploadPercentage = parseInt( Math.round( ( progressEvent.loaded * 100 ) / progressEvent.total ) );
            }.bind(this)
          }
        ).then(function(){
          console.log('SUCCESS!!');
        })
        .catch(function(){
          console.log('FAILURE!!');
        });
      },
    },
    filters: {
      limitText: function(value) {
        let count = value.length;
        if(count > 25){
          // return count;
          return value.substr(0, 20) + '... .' + value.split('.').pop();
          // return '...';
         /*  return value.replaceAt = function(index = count, character = '...'){
            return this.substr(0, index) + replacement+ this.substr(index + replacement.length);
          } */
        }else{
          return value;
        }
      }
    }
  }
</script> 

<style scoped>
  form#dropzone{
    display: block;
    height: 100px;
    /* width: 400px; */
    background: #ccc;
    margin: auto;
    margin-top: 10px;
    text-align: center;
    line-height: 100px;
      border-radius: 4px;
  }

  div.file-listing{
    /* width: 400px; */
    /* margin: auto; */
    padding: 10px;
    border-bottom: 1px solid #ddd;
  }
  div.file-listing img{
    /* height: 50px; */
    width: 100%;
    height: 10rem;
  }

  div.remove-container{
    text-align: right;
    position: absolute;
    z-index: 1;
    left: 15.1rem;
  }

  div.remove-container a{
    color: #fff !important;
    cursor: pointer;
    border-radius: 0px;
  }

  a.submit-button{
  display: block;
  margin: auto;
  text-align: center;
  width: 200px;
  padding: 10px;
  text-transform: uppercase;
  background-color: #CCC;
  color: white;
  font-weight: bold;
  margin-top: 20px;
}
progress{
  /* width: 400px; */
  margin: auto;
  display: block;
  margin-top: 20px;
  margin-bottom: 20px;
}
</style>