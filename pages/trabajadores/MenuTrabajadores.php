<style>
.d-flex {
    height: 95%;
}
.d-flex > .navbar{
    background: #a1aaad;
    border-radius: 15px; /* Bordes redondeados */
    color: white;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Sombra para profundidad */
    width: 90%;
    text-align: center;
    font-size: 18px;
    transition: transform 0.3s ease; 
}

.d-flex > .seleccionar:hover {
    transform: scale(1.05);
}

*, ::before, ::after {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'FontAwesome', sans-serif;
  background-color: #bccdde;
}

.navbar-toggler:hover{
  background-color: #bccdde;
}

</style>


<nav class="navbar bg-body-tertiary fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">INICIO</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">MENU</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <div class="d-flex align-items-start flex-column mb-3">
          <div class="navbar bg-body-tertiary p2">
              <div class="container-fluid">
                  <span class="navbar-brand mb-0 h1"><?php echo "Bienvenido " . $_SESSION["Nametrabajador"];?></span>
              </div>
          </div>
          <br>
          <div class="navbar seleccionar bg-body-tertiary p-2">
            <div class="container-fluid">
              <a class="navbar-brand" href="../controller/controllerCerrarSesion.php">    
                Cerrar sesión
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav>
