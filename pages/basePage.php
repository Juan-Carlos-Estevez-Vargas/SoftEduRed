<?php
class BasePage
{
    protected $pageTitle;

    /**
     * Constructor for the class.
     *
     * @param mixed $pageTitle The title of the page.
     */
    public function __construct($pageTitle)
    {
        $this->pageTitle = $pageTitle;
    }

    /**
     * Renders the header of the page.
     *
     * @throws Some_Exception_Class If there is an error including the "header.php" file.
     */
    protected function renderHeader()
    {
        include "common/header.php";
    }

    /**
     * Render the footer.
     *
     * @throws Some_Exception_Class description of exception
     */
    protected function renderFooter()
    {
        include "common/footer.php";
    }

    /**
     * Render the content of the page.
     *
     * This method should be overridden in the child classes to display the specific content of the page.
     *
     * @throws Some_Exception_Class description of exception
     */
    public function renderContent()
    {
        // Este método se debe sobrescribir en las clases hijas para mostrar el contenido específico de la página.
    }

    /**
     * Renders the HTML page.
     *
     * @return void
     */
    public function render()
    {
        echo '
        <!DOCTYPE html>
        <html lang="en">';

        $this->renderHeader();

        echo '
        <body>
          <main>
            <section class="h-100 bg-white">
              <div class="container py-3 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                  <div class="col">
                    <div class="card card-registration my-4">
                      <div class="row g-0">
                        <div class="col-xl-12">
                          <div class="card-body p-md-5 text-black" style="background-color: hsl(0, 0%, 96%)">';
            
                            // Llamamos a la función renderContent() para mostrar el contenido específico de la página.
                            $this->renderContent();

                          echo '
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          </main>

          <script src="../assets/js/deleteRecord.js"></script>
          ';

          $this->renderFooter();

        echo '
        </body>
        </html>';
    }
}
?>

