
function Bird() {
    this.y = height/2;
    this.x = 64

    this.gravity = .2;
    this.fly = 12
    this.velocity = 0;

    this.show = function () {
        fill(255)
        ellipse(this.x, this.y, 16, 16)
    }

    this.update = function() {
        this.velocity += this.gravity
        this.velocity *= 0.95
        this.y += this.velocity

        if (this.y > height) {
            this.y = height
            this.velocity = 0
        }

        if (this.y < 0) {
            this.y = 0
            this.velocity = 0
        }
    }

    this.up = function () {
        this.velocity -=  this.fly
    }
}

function Pipe() {
    this.top = random(height/2)
    this.bottom = random(height/2)
    this.x = width
    this.w = 20
    this.speed = 3

    this.show = function () {
        fill(255)
        rect(this.x, 0, this.w, this.top)
        rect(this.x, height-this.bottom, this.w, this.bottom)

    }

    this.update = function() {
        this.x -= this.speed
    }

    this.hits = function(bird) {
        if (bird.y < this.top || bird.y > height - this.bottom) {
            if (bird.x > this.x && bird.x < this.x + this.w) {
                return true
            }

        }
        return false
    }
}

var bird
var pipes = []

function setup() {
    createCanvas(400,600)
    bird = new Bird()
    pipes.push(new Pipe())
}

function draw() {
    background(0)
    bird.update()
    bird.show()

    if (frameCount % 60 == 0) {
        pipes.push(new Pipe())
    }

    for (var i=pipes.length-1; i >= 0; i--) {
        pipes[i].show()
        pipes[i].update()

        if (pipes[i].hits(bird)) {
            console.log("hit")
        }

        if (pipes[i].x < 0) {
            pipes.splice(i, 1)
        }
    }
}

function keyPressed() {
    if (key == ' ') {
        bird.up()
    }
}

