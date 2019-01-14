<html>
    <head>
    <title>TEST</title>
    </head>
<body>
    <input id="inputf" type="file" accept="video/*" />
    <input type="submit" onClick="reloadRandomFrame()" value="load random frame" /><br/>
    <canvas id="prevImgCanvas">Il tuo browser non supporta il tah canvas di HTML5</canvas>
    <input id="qui" type="file">
    <script>
        var video = document.createElement("video");

        var canvas = document.getElementById("prevImgCanvas");
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        video.addEventListener('loadeddata', function() {
            reloadRandomFrame();
        }, false);

        video.addEventListener('seeked', function() {
            var context = canvas.getContext('2d');
            console.log()
            context.drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
        }, false);

        var playSelectedFile = function(event) {
            var file = this.files[0];
            var fileURL = URL.createObjectURL(file);
            video.src = fileURL;
        }

        var input = document.getElementById('inputf');
        input.addEventListener('change', playSelectedFile, false);

        function reloadRandomFrame() {
          if (!isNaN(video.duration)) {
            var rand = Math.round(Math.random() * video.duration * 1000) + 1;
            video.currentTime = rand / 1000;
                console.log(document.getElementById('inputf').value)
                console.log(canvas.toDataURL())
                document.getElementById('inputf').value = canvas.toDataURL()
                console.log(document.getElementById('inputf').value)
          }
        }
    </script>
</body>
</html>