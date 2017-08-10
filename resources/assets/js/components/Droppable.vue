<template>
    <div>
        <div class="image-drop-box" :class="{ done: done, fail: fail, hover: hover, dragover: dragover, dragleave: dragleave, drop: drop }" @dragover.prevent="dragoverEvent" @dragleave.prevent="dragleaveEvent" @drop.prevent="dropEvent">
            <div v-if="files.length === 0" class="image-drop-box-default">
                <div class="image-drop-box-default_wrapper">
                    <div class="glyphicon glyphicon-download-alt image-drop-box-default__icon"></div>
                    <h4>Upload Images</h4>
                    <p>Drag and drop your images here. Supported formats: jpg, gif and png.</p>
                </div>
            </div>
            <div v-else class="image-drop-box-gallery">
                <div v-for="(fileChunk, chunkIndex) in fileChunks" :key="chunkIndex" class="image-drop-box-gallery__row">
                    <div v-for="(file, fileIndex) in fileChunk" :key="chunkIndex + '' + fileIndex" class="image-drop-box-gallery__box">
                        <div class="image-drop-box-gallery__border">
                            <div>
                                <div v-if="file.success === true" class="glyphicon glyphicon-ok image-drop-box-gallery__icon"></div>
                                <div v-if="file.success === false" class="glyphicon glyphicon-remove image-drop-box-gallery__icon"></div>
                                <div v-if="file.success === null" class="glyphicon glyphicon-picture image-drop-box-gallery__icon"></div>
                                <div>{{ file.name }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </div>
         <div class="btn-center">
            <button v-if="files.length > 0" @click="upload" class="btn btn-default">Upload {{ files.length }} {{ files.length > 1 ? 'Images' : 'Image' }}</button>
            <button v-else class="btn btn-default disabled" disabled="disabled">Upload Images</button>
        </div>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex'

    export default {
        data() {
            return {
                done: false,
                fail: false,
                hover: false,
                dragover: false,
                dragleave: false,
                drop: false,
                files: [],
                allowedMimes: ['image/jpeg', 'image/png', 'image/gif']
            }
        },
        methods: {
            dragoverEvent(event) {
                this.done = false
                this.hover = true
                return false;
            },
            dragleaveEvent(event) {
                this.hover = false
                return false;
            },
            dropEvent(event) {
                const MAXFILES = 12
                const length = event.dataTransfer.files.length < MAXFILES ? event.dataTransfer.files.length : MAXFILES

                this.files = []
                for (var i = 0; i < length; i++) {
                    this.files.push({
                        name: event.dataTransfer.files[i].name,
                        valid: _.includes(this.allowedMimes, event.dataTransfer.files[i].type),
                        success: null,
                        file: event.dataTransfer.files[i]
                    })
                }

                this.hover = false
                this.drop = true
                return false;
            },
            upload() {
                // const promises = []
                // this.files.forEach((file, index) => {
                //     promises.push(this.getNextFile(index))
                // })
                // axios.all(promises)
                //     .then(responses => {
                //         console.log(responses)
                //     })
                //     .catch(error => {
                //         console.log(error)
                //     })
                this.files.forEach((file, index) => {
                    if (file.valid !== true) {
                        this.files[index].success = false
                        this.goToGalleryIfDone()
                    } else {
                        this.getNextFile(index)
                            .then(response => {
                                this.files[index].success = true
                                this.goToGalleryIfDone()
                            })
                            .catch(error => {
                                console.log(error)
                            })
                    }
                })
            },
            getNextFile(index) {
                const data = new FormData;
                data.append('image', this.files[index].file)
                return axios.post('/api/images', data)
            },
            goToGalleryIfDone() {
                const pendingRequests = this.files.filter(file => file.success === null).length
                if (pendingRequests === 0) {
                    this.$emit('showImageGalleryTab')
                }
            }
        },
        computed: {
            fileChunks() {
                return _.chunk(this.files, 4);
            }
        }
    }
</script>

<style lang="scss" scoped>
    .image-drop-box {
        width: 100%;
        min-height: 200px;
        margin-bottom: 20px;
        display: flex;
    }
    .image-drop-box-default {
        background-color: #EEE;
        flex: 1;
        display: flex;
        align-items: center;
    }
    .image-drop-box-default_wrapper {
        flex: 1;
    }
    .image-drop-box-default__icon {
        font-size: 40px;
    }
    .image-drop-box-gallery {
        flex: 1;
    }
    .image-drop-box-gallery__row {
        display: flex;
        // justify-content: space-between;
    }
    .image-drop-box-gallery__box {
        padding: 10px;
        display: flex;
    }
    .image-drop-box-gallery__border {
        flex: 1;
        width: 192px;
        height: 192px;
        background-color: #FFF;
        align-items: center;
        border: 1px solid #555555;
        display: flex;
        justify-content: center;
    }
    .image-drop-box-gallery__icon {
        font-size: 40px;
    }
    //
    //
    //
    .image-drop-box__background {
        width: 100%;
        height: 100%;
        display: flex;
        flex: 1;
        align-items: center;
        justify-content: center;
    }
    .image-drop-box__background-icon {
        flex: 1;
        display: block;
        font-size: 100px;
    }
    .image-drop-box__filebox {
        padding: 10px;
        display: inline-block;
    }
    .image-drop-box__file {
        width: 192px;
        height: 192px;
        // vertical-align: center;
        // text-align: center;
        font-size: 30px;
        border: 1px solid #CCC;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .image-drop-box__fileicon {
        flex: 1;
    }
    // .image-drop-box .file.ng-enter-active {
    //     -webkit-animation-name: bounceIn;
    //     animation-name: bounceIn;
    // }
    // .image-drop-box .file.ng-leave-active {
    //     -webkit-animation-name: bounceOut;
    //     animation-name: bounceOut;
    // }
    .image-drop-box .file .file-icon {
        font-size: 100px;
    }
    .image-drop-box .file .file-name {
        font-size: 10px;
        font-size: 1rem;
    }
    .image-drop-box .drop-icon-wrapper {
        position: absolute;
        width: 100%;
        top: 7rem;
    }
    .image-drop-box .drop-icon {
        -webkit-animation-duration: 1s;
        animation-duration: 1s;
        -webkit-animation-delay: 0s;
        animation-delay: 0s;
        -webkit-animation-fill-mode: both;
        animation-fill-mode: both;
        position: relative;
        top: 1px;
        display: inline-block;
        font-family: 'Glyphicons Halflings';
        font-style: normal;
        font-weight: normal;
        line-height: 1;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        font-size: 50px;
        font-size: 5rem;
        color: #FAFAFA;
    }
    .image-drop-box .drop-icon:before {
        content: "\e125";
    }
    .image-drop-box.hover .drop-icon {
        -webkit-animation-name: pulse;
        animation-name: pulse;
        color: #CCCCCC;
        -webkit-animation-iteration-count: infinite;
        animation-iteration-count: infinite;
    }
    .image-drop-box.drop .drop-icon {
        color: #CCCCCC;
    }
    .image-drop-box.done .drop-icon {
        color: #33CCCC;
    }
    .image-drop-box.done .drop-icon:before {
        content: "\e013";
    }
    .image-drop-box.fail .drop-icon {
        color: #CC6699;
    }
    .image-drop-box.fail .drop-icon:before {
        content: "\e014";
    }
</style>
