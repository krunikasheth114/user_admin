<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>

</head>
<style>
    body{
    margin: 0;
    font-family: Ubuntu;
    
}

.card{
    position: absolute;
    top: 50%;
    left:50%;
    transform: translate(-50%, -50%);

    width: 250px;
    height:437.5px;
  
    border-radius: 5px;
    background: white;
    box-shadow: 2px 2px 10px 3px rgba(0,0,0, .15)
}

.top{
    position: relative;
    top:0;

    height:25%;
    width:100%;

    background: hsl(180, 100%, 30%);
    color: white;
    font-weight: bold;
    font-size: 1.5em;

    border-radius: 5px 5px 0px 0px ;
    text-align: center;
    padding-top:10%;

}
.picture{
   
    width: 100px;
    height:100px;
    border-radius:50%;
    border: 2px solid white;

    position: absolute;
    left:0;
    right:0;
    top:50%;
    margin: auto;

    transition: transform 250ms ease;
          
    &::before{
      content:"12";
      font-size: .65em;
      font-weight: thin;
      position: absolute;
      right:2.5%;
      top:0;
      width:20px;
      height:20px;
      border-radius:50%;
      background: yellow;
      color: black;
    }
    &:hover{
      transform: scale(1.1)
  }
}
.bottom{
    position: relative;
    font-size: 0.75em;
    text-align:center;
}
.name{
    font-size: 2.2em;
    font-weight: bold;

    padding-top: 20%;
    padding-bottom: 5%;
}

.description{
    font-size: 1.25em;
    line-height: 125%;
    
    padding-left:10%;
    padding-right:10%;
}

.customize{
    position: relative;
    margin-top: 7.5%;
    padding: .5em .75em;
  
    font-size: 1.25em;

    background: hsl(180, 100%, 30%);
    color: white;
    font-weight: bold;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  
    &a{
      color: white;
      text-decoration: none;
    }
    &:hover{
      background:hsl(180, 100%, 35%);
    }
    &:active{
      background:hsl(180, 100%, 20%);
    }
}
.else{
    font-size: .90em;
}
</style>
<body>
    <div class="card">
        <div class="top"><span>Here is Your One Time Password: {{$otp}} Please verify Your account.</span>
        
            <div class="bottom">
           
            <a href="#"><button class="customize">Thank you</button></a>
            </div>
        </div>
    </div>
</body>
</html>