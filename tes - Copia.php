<html>
    <head>
    <title>TEST</title>
    </head>
<body>
    <input type="file" id="upload"/>
    <img id="thumbnail"/>

<script>
    var input = document.getElementById('upload')
    var img = document.getElementById('thumbnail')

    input.addEventListener('change', function(event){
        var file = this.files[0]
        var url = URL.createObjectURL(file)

        var video = document.createElement('video')      
        video.src = url
        

        var snapshot = function(){
            var canvas = document.createElement('canvas')
            var ctx = canvas.getContext('2d')

            ctx.drawImage(video, 0, 0, canvas.width, canvas.height)
            img.src = canvas.toDataURL('image/png')

            video.removeEventListener('canplay', snapshot)
        }

        video.addEventListener('canplay', snapshot)
    })
</script>
</body>
</html>