@extends("Staff.Layouts.Master")
@section('Title', 'Face Registration')
@section('Content')
<div class="container-scroller">
    <x-staff.layouts.header-dashboard/>
    <div class="container-fluid page-body-wrapper">
        <div class="theme-setting-wrapper">
        </div>
        <div class="side-bar-box" style="width: 250px;">
            <x-staff.layouts.side-bar/>
        </div>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="container bg-white" style="padding-top: 10px;">
            <div class="shadow-smbox" style="margin: auto;width: 660px;padding: 10px;">
                <h3 class="text-center mb-4">Face Registration</h3>
                <div id="status-message" class="alert alert-info text-center mb-3"></div>
                <div id="ok"></div>
                <video id="player" controls autoplay width="640px" height="480px"></video>
                <button id="capture" class="d-none">Capture</button>
                <div class="text-center mt-3">
                    <div class="progress mb-3" style="height: 20px;">
                        <div id="registration-progress" class="progress-bar" role="progressbar" style="width: 0%"></div>
                    </div>
                    <p id="status" class="fz95 tx">Loading camera...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    #ok {
        position: absolute;
        width: 640px;
        height: 480px;
        opacity: 0.3;
        background: linear-gradient(#03A9F4,#03A9F4), 
        linear-gradient(90deg, #ffffff33 1px,transparent 0,transparent 19px),
        linear-gradient(#ffffff33 1px,transparent 0,transparent 19px),
        linear-gradient(transparent, #2196f387);
        background-size:100% 1.5%, 10% 100%,100% 10%, 100% 100%;
        background-repeat: no-repeat,repeat,repeat,no-repeat;
        background-position: 0 0,0 0, 0 0, 0 0;
        clip-path: polygon(0% 0%, 100% 0%, 100% 1.5%, 0% 1.5%);
        animation: move 2s infinite linear;
    }
    @keyframes move {
        to {
            background-position: 0 100%,0 0, 0 0, 0 0;
            clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%);
        }
    }
    .box {
        --b:5px;
        --c:red;
        --w:20px;
        border:var(--b) solid transparent;
        --g:#0000 90deg,var(--c) 0;
        background:
        conic-gradient(from 90deg  at top    var(--b) left  var(--b),var(--g)) 0    0,
        conic-gradient(from 180deg at top    var(--b) right var(--b),var(--g)) 100% 0,
        conic-gradient(from 0deg   at bottom var(--b) left  var(--b),var(--g)) 0    100%,
        conic-gradient(from -90deg at bottom var(--b) right var(--b),var(--g)) 100% 100%;
        background-size:var(--w) var(--w);
        background-origin:border-box;
        background-repeat:no-repeat;
    }
    #status-message {
        display: none;
    }
    .progress {
        background-color: #f5f5f5;
        border-radius: 4px;
    }
    .progress-bar {
        background-color: #03A9F4;
        transition: width 0.3s ease-in-out;
    }
</style>

<script type="text/javascript">
    var countFace = 0;
    var player = document.getElementById('player');
    var snapshotCanvas = document.getElementById('snapshot');
    var captureButton = document.getElementById('capture');
    var statusMessage = document.getElementById('status-message');
    var registrationProgress = document.getElementById('registration-progress');
    var statusText = document.getElementById('status');

    function showMessage(message, type = 'info') {
        statusMessage.textContent = message;
        statusMessage.className = `alert alert-${type} text-center mb-3`;
        statusMessage.style.display = 'block';
    }

    function updateProgress(progress) {
        registrationProgress.style.width = `${progress}%`;
        statusText.textContent = `${countFace}/3 face samples captured`;
    }

    var handleSuccess = function(stream) {
        player.srcObject = stream;
        statusText.textContent = 'Camera ready. Starting face capture...';
        
        setInterval(async () => {
            if (countFace < 3) {
                $('#capture').click();
                countFace++;
                updateProgress((countFace / 3) * 100);
                
                if (countFace === 3) {
                    showMessage('Face registration completed successfully! Redirecting...', 'success');
                    setTimeout(() => {
                        window.location.href = "{{url('identity-management')}}";
                    }, 2000);
                }
            }
        }, 7000);
    };

    captureButton.addEventListener('click', function() {
        var context = snapshotCanvas.getContext('2d');
        context.drawImage(player, 0, 0, snapshotCanvas.width, snapshotCanvas.height);
        
        var data = new FormData();
        data.append("image", snapshotCanvas.toDataURL('image/jpeg'));

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: '{{url('register-faces')}}',
            processData: false,
            contentType: false,
            data: data,
            success: function(response) {
                if (response.success) {
                    showMessage('Face sample captured successfully!', 'success');
                } else {
                    showMessage('Failed to capture face sample. Please try again.', 'danger');
                }
            },
            error: function(xhr) {
                showMessage('Error: ' + (xhr.responseJSON?.error || 'Failed to capture face sample'), 'danger');
            }
        });
    });

    navigator.mediaDevices.getUserMedia({video: true})
        .then(handleSuccess)
        .catch(function(err) {
            showMessage('Error accessing camera: ' + err.message, 'danger');
            statusText.textContent = 'Camera access failed';
        });
</script>
@endsection








