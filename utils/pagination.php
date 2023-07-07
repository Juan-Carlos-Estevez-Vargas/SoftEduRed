<?php
  // Calcular el número total de páginas
  $totalPages = ceil($totalRecords / $recordsPerPage);
  
  // Mostrar el botón "Anterior" solo si no estamos en la primera página
  if ($currentPage > 1) {
      echo '<li class="page-item"><a class="page-link" href="?page=' . ($currentPage - 1) . '">Anterior</a></li>';
  }
  
  // Mostrar enlaces a las páginas individuales
  for ($i = 1; $i <= $totalPages; $i++) {
      echo '<li class="page-item';
      if ($i == $currentPage) {
          echo ' active';
      }
      echo '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
  }
                  
  // Mostrar el botón "Siguiente" solo si no estamos en la última página
  if ($currentPage < $totalPages) {
      echo '<li class="page-item"><a class="page-link" href="?page=' . ($currentPage + 1) . '">Siguiente</a></li>';
  }
?>