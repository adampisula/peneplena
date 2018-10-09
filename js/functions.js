function getImageLightness(imageSrc, side, callback) {
    var img = document.createElement("img");
    img.src = imageSrc;
    img.style.display = "none";
    document.body.appendChild(img);

    var colorSum = 0;

    img.onload = function() {
        var canvas = document.createElement("canvas");
        canvas.width = this.width;
        canvas.height = this.height;

        var ctx = canvas.getContext("2d");
        ctx.drawImage(this,0,0);

        var imageData;

        if(side == 0)
            imageData = ctx.getImageData(0, 0, canvas.width, canvas.height / 2);

        if(side == 1)
            imageData = ctx.getImageData(0, canvas.height / 2, canvas.width, canvas.height);

        var data = imageData.data;
        var r,g,b,avg;

        for(var x = 0, len = data.length; x < len; x+=4) {
            r = data[x];
            g = data[x+1];
            b = data[x+2];

            avg = Math.floor((r+g+b)/3);
            colorSum += avg;
        }

        var brightness = Math.floor(colorSum / (this.width*this.height / 2));
        callback(brightness);
    }
}

function getAverageColor(imageSrc, callback) {
    var img = document.createElement("img");
    img.src = imageSrc;
    img.style.display = "none";
    document.body.appendChild(img);

    var colorSumR = 0;
    var colorSumG = 0;
    var colorSumB = 0;

    img.onload = function() {
        var canvas = document.createElement("canvas");
        canvas.width = this.width;
        canvas.height = this.height;

        var ctx = canvas.getContext("2d");
        ctx.drawImage(this, 0, 0);

        var imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);

        var data = imageData.data;
        var r,g,b;

        for(var x = 0, len = data.length; x < len; x+=4) {
            r = data[x];
            g = data[x+1];
            b = data[x+2];

            colorSumR += r;
            colorSumG += g;
            colorSumB += b;
        }

        var r = Math.floor(colorSumR / (this.width * this.height));
        var g = Math.floor(colorSumG / (this.width * this.height));
        var b = Math.floor(colorSumB / (this.width * this.height));

        callback(r + "," + g + "," + b);
    }
}