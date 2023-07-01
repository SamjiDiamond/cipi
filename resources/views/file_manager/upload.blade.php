@extends('template')


@section('title')
    File Manager
@endsection


<style>
    * {
        box-sizing: border-box;
        font-family: -apple-system, BlinkMacSystemFont, "segoe ui", roboto, oxygen, ubuntu, cantarell, "fira sans", "droid sans", "helvetica neue", Arial, sans-serif;
        font-size: 16px;
    }

    body {
        margin: 0;
        padding: 15px;
        background-color: #63a7df;
    }

    #upload-form h1 {
        margin: 0;
        padding: 15px;
        font-size: 20px;
        font-weight: 500;
        color: #434850;
        text-align: center;
    }

    #upload-form label {
        display: flex;
        flex-flow: column;
        justify-content: center;
        align-items: center;
        background-color: #fafbfb;
        border: 1px solid #e6e8ec;
        color: #737476;
        padding: 10px 12px;
        font-weight: 500;
        font-size: 14px;
        margin: 10px auto;
        width: 50%;
        border-radius: 4px;
        cursor: pointer;
    }

    .upload-form label i {
        margin-right: 10px;
        padding: 5px 0;
        color: #dbdce0;
    }

    .upload-form label span {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        word-break: break-all;
    }

    .upload-form label:hover {
        background-color: #f7f8f9;
        border: 1px solid #e3e5ea;
        color: #68686a;
    }

    .upload-form label:hover i {
        color: #cfd1d4;
    }

    #upload-form input[type="file"] {
        margin: 0 auto;
        font-size: 20px;
        cursor: pointer;
    }

    #upload-form .progress {
        height: 20px;
        border-radius: 4px;
        margin: 10px 0;
        background-color: #e6e8ec;
    }

    #upload-form button {
        appearance: none;
        border-radius: 4px;
        font-weight: 500;
        font-size: 14px;
        border: 0;
        padding: 10px 12px;
        margin-top: 10px;
        color: #fff;
        cursor: pointer;
    }


    .upload-form button:disabled {
        background-color: #aca7a5;
    }

    .upload-form .result {
        padding-top: 15px;
    }

    #upload-form{
        padding: 30px;
    }
</style>

@section('content')
    <div class="row">
        <div class="col">
            <div class="card m-4">

                <form class="text-center" id="upload-form" action="{{ route('file.upload.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <h1>Upload File</h1>
                    <div class="m-3 tex-center">
                        <input id="files" type="file" name="files">
                    </div>
                    <div>
                        <input type="hidden" value="{{ request('path')}}" name="path">
                    </div>
                    <div class="progress m-3"></div>
                    <div class="text-center m-3">
                        <button class="btn btn-success text-center" type="submit">Upload</button>
                    </div>
                    <div class="result"></div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
       $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    // $('#upload-form').on('submit', (e) => {
    //     e.preventDefault();
    //     console.log(new FormData($('#upload-form')[0]));
    //     $.ajax({
    //         url: '{{ route('file.upload.store') }}',
    //         type: 'POST',
    //         data: (new FormData($('#upload-form')[0]).file),
    //         processData: false,
    //         contentType: false,
    //         cache: false,
    //         beforeSend: () => {
    //             $('.progress').on('progress', (event) => {
    //                 // Add the current progress to the button
    //                 $('button').innerHTML = 'Uploading... ' + '(' + ((event.loaded / event
    //                     .total) * 100).toFixed(2) + '%)';
    //                 // Update the progress bar
    //                 $('.progress').style.background =
    //                     'linear-gradient(to right, #25b350, #25b350 ' + Math.round((event
    //                         .loaded / event.total) * 100) + '%, #e6e8ec ' + Math.round((
    //                         event.loaded / event.total) * 100) + '%)';
    //                 // Disable the submit button
    //                 $('button').disabled = true;
    //             });
    //         },
    //         success: (data) => {
    //             console.log(data);
    //             $('.result').innerHTML = data.responseText;
    //         },
    //         error: (data) => {
    //             console.log(data);
    //             $('.result').innerHTML = data.responseText;
    //         }
    //     });
    // })



    //     // Declare global variables for easy access 
    //     const uploadForm = document.querySelector('.upload-form');
    //     const filesInput = document.querySelector('#files');

    // // // Attach submit event handler to form
    // uploadForm.addEventListener('submit', (event) => {
    //     event.preventDefault();
    //     // Make sure files are selected
    //     if (!filesInput.files.length) {
    //         document.querySelector('.result').innerHTML = 'Please select a file!';
    //     } else {
    //         console.log('here');
    //         // Create the form object
    //         let uploadFormDate = new FormData(uploadForm);
    //         // Initiate the AJAX request
    //         let request = new XMLHttpRequest();
    //         // Ensure the request method is POST
    //         request.open('POST', uploadForm.action);
    //         // Attach the progress event handler to the AJAX request
    //         request.upload.addEventListener('progress', event => {
    //             // Add the current progress to the button
    //             document.querySelector('button').innerHTML = 'Uploading... ' + '(' + ((event.loaded/event.total)*100).toFixed(2) + '%)';
    //             // Update the progress bar
    //             document.querySelector('.progress').style.background = 'linear-gradient(to right, #25b350, #25b350 ' + Math.round((event.loaded/event.total)*100) + '%, #e6e8ec ' + Math.round((event.loaded/event.total)*100) + '%)';
    //             // Disable the submit button
    //             document.querySelector('button').disabled = true;
    //         });
    //         // The following code will execute when the request is complete
    //         request.onreadystatechange = () => {
    //             if (request.readyState == 4 && request.status == 200) {
    //                 // Output the response message
    //                 document.querySelector('.result').innerHTML = request.responseText;
    //             }
    //         };
    //         // Execute request
    //         request.send(uploadFormDate);
    //     }
    // });
</script>
@endsection
