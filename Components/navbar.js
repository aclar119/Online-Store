class Navbar extends HTMLElement {
    constructor() {
        super();
    }

    connectedCallback() {
        this.innerHTML = `
      <style>
        #navbar {
            display: grid;
            background-color: #213536;
        }
        
        #navbar-left {
            display: flex;
            grid-column: 1;
        }
        
        #navbar-right {
            display: flex;
            grid-column: 2;
            justify-content: end;
        }
        
        #logo {
            display: flex;
            height: 50px;
            padding-left: 16px;
            padding-right: 16px;
            align-items: center;
            justify-items: center;
        }
        
        #logo:hover{
            cursor: pointer;
            opacity: 60%;
        }
        
        #navbar a {
            z-index: 1;
            display: block;
            color: #F8F8F8;
            text-align: center;
            padding-top: 14px;
            padding-bottom: 14px;
            padding-left: 16px;
            padding-right: 16px;
            text-decoration: none;
            font-size: 18px;
        }
        
        #navbar a:hover {
            opacity: 60%;
            border-bottom: 3px solid #F8F8F8;
            padding-bottom: 11px;
        }
        
        #search-bar {
            display: flex;
            align-items: center;
            justify-content: end;
            padding-right: 16px;
        }
        
        #search-bar div {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: space-between;
            height:fit-content;
            border-bottom: 2px solid #F8F8F8;
            padding-bottom: 0;
            width: 80%;
        }
        
        #search-bar button {
            height: auto;
            border: none;
            background-color: #00000000;
        }
        
        #search-bar img {
            height: 20px;
        }
        
        #search-input {
            opacity: 100%;
            font-size: 18px;
            border: none;
            text-align: end;
            color: #F8F8F8;
            background-color: #00000000;
            width: 100%;
        }
        
        #search-input:focus {
            border: none;
            background-color: #00000000;
            outline: none;
        }
        
        #search-input::placeholder {
            color: #F8F8F8;
            opacity: 60%;
        }
        
        #cart {
            display: flex;
            height: calc(100% - 3px);
            padding-left: 16px;
            padding-right: 16px;
            padding-bottom: 3px;
            align-items: center;
            justify-items: center;
        }
        
        #cart:hover {
            cursor: pointer;
            opacity: 60%;
            border-bottom: 3px solid #F8F8F8;
            padding-bottom: 0px;
        }

      </style>

      <div id="navbar">
            <div id="navbar-left">
                <div id="logo" onclick="window.location.href='../Home/Home.html';"><img src="../Icons/Logo.png" height="32" ></div>
                <div><a href="../BrowseProducts/BrowseProducts.html">Store</a></div>
                <div><a href="../AboutUs/AboutUs.html">About Us</a></div>
            </div>

            <div id="navbar-right">
                <form id="search-bar" action="../BrowseProducts/BrowseProducts.html">
                    <div>
                        <button><img src="../Icons/Search.png"></button>
                        <input id="search-input" type="text" placeholder="Search" name="search" autocomplete="off">
                    </div>
                </form>
                <div id="cart" onclick="window.location.href='../Cart/Cart.html';"><img src="../Icons/Cart.png" height="32" ></div>
            </div>
        </div>
    `;
  }
}
customElements.define('navbar-component', Navbar);