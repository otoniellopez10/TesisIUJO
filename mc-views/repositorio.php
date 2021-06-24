<?php 
session_start();
if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    die();
}
$acceso = array(2,3); //1 para administrador, 2 para colaborador y 3 para persona comun
$user_id = $_SESSION["user"]->rol_id;
if ($user_id == 1){
    header('Location: panel_admin.php');
    die();
}else if (!in_array($user_id, $acceso)) {
    header('Location: error.php');
    die();
}

include_once '../mc-models/Libro.php';
include_once '../mc-models/Autor.php';
include_once '../mc-models/Carrera.php';
include_once '../mc-models/Categoria.php';
include_once '../mc-models/Editorial.php';

$objLibro = new Libro();
$objAutor = new Autor();
$objCarrera = new Carrera();
$objCategoria = new Categoria();
$objEditorial = new Editorial();


$libros = $objLibro->getAll(25);
$librosRecomendados = $objLibro->getRecomendados(25);
$librosMejorCalificados = $objLibro->getMejorCalificados(25);
$librosMasDescargados = $objLibro->getMasDescargados(25);
$librosMasVistos = $objLibro->getMasVistos(25);


$carreras = $objCarrera->getAll();
$categorias = $objCategoria->getAll();
$editoriales = $objEditorial->getAll();
?>

<!DOCTYPE html>
<html>
    <head>
        <!--Import Google Icon Font-->
        <link href="../assets/librerias/css/material-icons.css" rel="stylesheet" />
        <link href="../assets/librerias/css/datatables.min.css" rel="stylesheet" />
        <!--Import materialize.css-->
        <link
            type="text/css"
            rel="stylesheet"
            href="../assets/librerias/css/materialize.min.css"
            media="screen,projection"
        />
        <link rel="stylesheet" href="../assets/css/estilos.css" />
        <link rel="stylesheet" href="../assets/css/repositorio.css" />

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <title>IUJO Repositorio | Inicio</title>
    </head>

    <body>
        
        <!-- añadir menu -->
        <?php
            if($user_id == 1) include_once "menuAdministrador.php";
            if($user_id == 2) include_once "menuColaborador.php";
            if($user_id == 3) include_once "menuPersona.php";
        ?>

        <main>
            <div id="modulo">
                <h5>
                    <i class="material-icons left teal-text">book</i>Repositorio de libros
                </h5>
                
                <!-- contenido panel administradr -->
                
                <nav class="nav-extended teal" id="nav" style="margin-bottom: 20px;">
                    <div class="nav-content">
                        <ul class="tabs tabs-transparent">
                            <li class="tab"><a class="" href="#test1">Recomendados</a></li>
                            <li class="tab"><a class="" href="#test2">Mejor calificados</a></li>
                            <li class="tab"><a class="" href="#test3">Más descargados</a></li>
                            <li class="tab"><a class="" href="#test4">Más vistos</a></li>
                            <li class="tab"><a class="active" href="#test5">Buscar</a></li>
                        </ul>
                    </div>
                </nav>

                <!-- libros recomendados -->
                <div id="test1" class="row modulo_contenido">
                    <?php
                        render($librosRecomendados);
                    ?>
                </div>

                <!-- libros mejor calificados -->
                <div id="test2" class="row modulo_contenido">
                    <?php
                        render($librosMejorCalificados);
                    ?>
                </div>

                <!-- Libros mas descargados -->
                <div id="test3" class="row modulo_contenido">
                    <?php
                        render($librosMasDescargados);
                    ?>
                </div>

                <div id="test4" class="row modulo_contenido">
                    <?php
                        render($librosMasVistos);
                    ?>
                </div>

                <!-- Buscar -->
                <div id="test5" class="row">

                    <!-- buscar libro -->
                    <div class="col s12 modulo_contenido" id="c_form_buscador">
                        <p class="section teal-text">* Filtrar libros</p>
                        <form action="" id="form_buscar_libro">
                            <div class="row">

                                <div class="col s12 m6 input-field">
                                    <input type="text" id="b_titulo" name="b_titulo"/>
                                    <label for="b_titulo">Buscar por título:</label>
                                </div>

                                <div class="input-field col s12 m6">
                                    <input type="text" id="b_autor" name="b_autor" class="autocomplete">
                                    <label for="b_autor">Buscar por autor</label>
                                </div>

                                <!-- editorial -->
                                <div class="col s12 m6 l4 input-field">
                                    <select id="b_editorial" name="b_editorial" >
                                        <option value="" selected>Todas</option>
                                        <?php
                                            foreach ($editoriales as $e) {
                                        ?>
                                            <option value="<?= $e->id; ?>"> <?= $e->nombre; ?> </option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                    <label for="b_editorial">Buscar por editorial:</label>
                                </div>

                                <!-- categoria -->
                                <div class="col s12 m6 l4 input-field">
                                    <select id="b_categoria" name="b_categoria" >
                                        <option value="" selected>Todas</option>
                                        <?php
                                            foreach ($categorias as $c) {
                                        ?>
                                            <option value="<?= $c->id; ?>"> <?= $c->nombre; ?> </option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                    <label for="b_categoria">Buscar por categoría:</label>
                                </div>

                                <!-- carrera -->
                                <div class="col s12 m12 l4 input-field">
                                    <select id="b_carrera" name="b_carrera" >
                                        <option value="" selected>General</option>
                                        <?php
                                            foreach ($carreras as $c) {
                                                if($c->nombre == "General") continue;
                                        ?>
                                            <option value="<?= $c->id; ?>"> <?= $c->nombre; ?> </option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                    <label for="b_carrera">Buscar por carrera:</label>
                                </div>

                                <div class="col s12 right-align">
                                    <button type="button" class="btn-flat waves-effect waves-light" id="btnLimpiarCampos" onclick="limpiarCampos()">Limpiar campos</button>
                                    
                                    <button type="submit" class="btn waves-effect waves-light" id="btnBuscar">Buscar</button>
                                </div>

                            </div>
                        </form>
                    </div>

                    <button class="btn-flat waves-effect waves-light tooltipped" data-position="right" data-tooltip="Volver" onclick="cerrarResultados()" id="btnCerrarResultados"><i class="material-icons teal-text left">arrow_back</i>Volver</button>

                    <div class="col s12 modulo_contenido" id="c_resultados_busqueda">
                    </div>
                </div>

                <div id="prueba">
                    <table id="tablePrueba" class="striped">
                        <thead class="teal-text">
                            <th>#</th>
                            <th>Título</th>
                            <th>Editorial</th>
                            <th>Edición</th>
                            <th>Fecha</th>
                            <th>Categoría</th>
                            <th>Acciones</th>
                        </thead>
                        <tbody id="tbodyResultados">
                            <tr>
                                <td>1</td>
                                <td>Otoniel 1</td>
                                <td>Lopez 1</td>
                                <td>0424 0000001</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Otoniel 2</td>
                                <td>Lopez 2</td>
                                <td>0424 0000002</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Otoniel 3</td>
                                <td>Lopez 3</td>
                                <td>0424 0000003</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Otoniel 4</td>
                                <td>Lopez 4</td>
                                <td>0424 0000004</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Otoniel 5</td>
                                <td>Lopez 5</td>
                                <td>0424 0000005</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Otoniel 6</td>
                                <td>Lopez 6</td>
                                <td>0424 0000006</td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>Otoniel 7</td>
                                <td>Lopez 7</td>
                                <td>0424 0000007</td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>Otoniel 8</td>
                                <td>Lopez 8</td>
                                <td>0424 0000008</td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>Otoniel 9</td>
                                <td>Lopez 9</td>
                                <td>0424 0000009</td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>Otoniel 10</td>
                                <td>Lopez 10</td>
                                <td>0424 0000010</td>
                            </tr>
                            <tr>
                                <td>11</td>
                                <td>Otoniel 11</td>
                                <td>Lopez 11</td>
                                <td>0424 0000011</td>
                            </tr>
                            <tr>
                                <td>12</td>
                                <td>Otoniel 12</td>
                                <td>Lopez 12</td>
                                <td>0424 0000012</td>
                            </tr>
                            <tr>
                                <td>13</td>
                                <td>Otoniel 13</td>
                                <td>Lopez 13</td>
                                <td>0424 0000013</td>
                            </tr>
                            <tr>
                                <td>14</td>
                                <td>Otoniel 14</td>
                                <td>Lopez 14</td>
                                <td>0424 0000014</td>
                            </tr>
                            <tr>
                                <td>15</td>
                                <td>Otoniel 15</td>
                                <td>Lopez 15</td>
                                <td>0424 0000015</td>
                            </tr>
                            <tr>
                                <td>16</td>
                                <td>Otoniel 16</td>
                                <td>Lopez 16</td>
                                <td>0424 0000016</td>
                            </tr>
                            <tr>
                                <td>17</td>
                                <td>Otoniel 17</td>
                                <td>Lopez 17</td>
                                <td>0424 0000017</td>
                            </tr>
                            <tr>
                                <td>18</td>
                                <td>Otoniel 18</td>
                                <td>Lopez 18</td>
                                <td>0424 0000018</td>
                            </tr>
                            <tr>
                                <td>19</td>
                                <td>Otoniel 19</td>
                                <td>Lopez 19</td>
                                <td>0424 0000019</td>
                            </tr>
                            <tr>
                                <td>20</td>
                                <td>Otoniel 20</td>
                                <td>Lopez 20</td>
                                <td>0424 0000020</td>
                            </tr>
                            <tr>
                                <td>21</td>
                                <td>Otoniel 21</td>
                                <td>Lopez 21</td>
                                <td>0424 0000021</td>
                            </tr>
                            <tr>
                                <td>22</td>
                                <td>Otoniel 22</td>
                                <td>Lopez 22</td>
                                <td>0424 0000022</td>
                            </tr>
                            <tr>
                                <td>23</td>
                                <td>Otoniel 23</td>
                                <td>Lopez 23</td>
                                <td>0424 0000023</td>
                            </tr>
                            <tr>
                                <td>24</td>
                                <td>Otoniel 24</td>
                                <td>Lopez 24</td>
                                <td>0424 0000024</td>
                            </tr>
                            <tr>
                                <td>25</td>
                                <td>Otoniel 25</td>
                                <td>Lopez 25</td>
                                <td>0424 0000025</td>
                            </tr>
                            <tr>
                                <td>26</td>
                                <td>Otoniel 26</td>
                                <td>Lopez 26</td>
                                <td>0424 0000026</td>
                            </tr>
                            <tr>
                                <td>27</td>
                                <td>Otoniel 27</td>
                                <td>Lopez 27</td>
                                <td>0424 0000027</td>
                            </tr>
                            <tr>
                                <td>28</td>
                                <td>Otoniel 28</td>
                                <td>Lopez 28</td>
                                <td>0424 0000028</td>
                            </tr>
                            <tr>
                                <td>29</td>
                                <td>Otoniel 29</td>
                                <td>Lopez 29</td>
                                <td>0424 0000029</td>
                            </tr>
                            <tr>
                                <td>30</td>
                                <td>Otoniel 30</td>
                                <td>Lopez 30</td>
                                <td>0424 0000030</td>
                            </tr>
                            <tr>
                                <td>31</td>
                                <td>Otoniel 31</td>
                                <td>Lopez 31</td>
                                <td>0424 0000031</td>
                            </tr>
                            <tr>
                                <td>32</td>
                                <td>Otoniel 32</td>
                                <td>Lopez 32</td>
                                <td>0424 0000032</td>
                            </tr>
                            <tr>
                                <td>33</td>
                                <td>Otoniel 33</td>
                                <td>Lopez 33</td>
                                <td>0424 0000033</td>
                            </tr>
                            <tr>
                                <td>34</td>
                                <td>Otoniel 34</td>
                                <td>Lopez 34</td>
                                <td>0424 0000034</td>
                            </tr>
                            <tr>
                                <td>35</td>
                                <td>Otoniel 35</td>
                                <td>Lopez 35</td>
                                <td>0424 0000035</td>
                            </tr>
                            <tr>
                                <td>36</td>
                                <td>Otoniel 36</td>
                                <td>Lopez 36</td>
                                <td>0424 0000036</td>
                            </tr>
                            <tr>
                                <td>37</td>
                                <td>Otoniel 37</td>
                                <td>Lopez 37</td>
                                <td>0424 0000037</td>
                            </tr>
                            <tr>
                                <td>38</td>
                                <td>Otoniel 38</td>
                                <td>Lopez 38</td>
                                <td>0424 0000038</td>
                            </tr>
                            <tr>
                                <td>39</td>
                                <td>Otoniel 39</td>
                                <td>Lopez 39</td>
                                <td>0424 0000039</td>
                            </tr>
                            <tr>
                                <td>40</td>
                                <td>Otoniel 40</td>
                                <td>Lopez 40</td>
                                <td>0424 0000040</td>
                            </tr>
                            <tr>
                                <td>41</td>
                                <td>Otoniel 41</td>
                                <td>Lopez 41</td>
                                <td>0424 0000041</td>
                            </tr>
                            <tr>
                                <td>42</td>
                                <td>Otoniel 42</td>
                                <td>Lopez 42</td>
                                <td>0424 0000042</td>
                            </tr>
                            <tr>
                                <td>43</td>
                                <td>Otoniel 43</td>
                                <td>Lopez 43</td>
                                <td>0424 0000043</td>
                            </tr>
                            <tr>
                                <td>44</td>
                                <td>Otoniel 44</td>
                                <td>Lopez 44</td>
                                <td>0424 0000044</td>
                            </tr>
                            <tr>
                                <td>45</td>
                                <td>Otoniel 45</td>
                                <td>Lopez 45</td>
                                <td>0424 0000045</td>
                            </tr>
                            <tr>
                                <td>46</td>
                                <td>Otoniel 46</td>
                                <td>Lopez 46</td>
                                <td>0424 0000046</td>
                            </tr>
                            <tr>
                                <td>47</td>
                                <td>Otoniel 47</td>
                                <td>Lopez 47</td>
                                <td>0424 0000047</td>
                            </tr>
                            <tr>
                                <td>48</td>
                                <td>Otoniel 48</td>
                                <td>Lopez 48</td>
                                <td>0424 0000048</td>
                            </tr>
                            <tr>
                                <td>49</td>
                                <td>Otoniel 49</td>
                                <td>Lopez 49</td>
                                <td>0424 0000049</td>
                            </tr>
                            <tr>
                                <td>50</td>
                                <td>Otoniel 50</td>
                                <td>Lopez 50</td>
                                <td>0424 0000050</td>
                            </tr>
                            <tr>
                                <td>51</td>
                                <td>Otoniel 51</td>
                                <td>Lopez 51</td>
                                <td>0424 0000051</td>
                            </tr>
                            <tr>
                                <td>52</td>
                                <td>Otoniel 52</td>
                                <td>Lopez 52</td>
                                <td>0424 0000052</td>
                            </tr>
                            <tr>
                                <td>53</td>
                                <td>Otoniel 53</td>
                                <td>Lopez 53</td>
                                <td>0424 0000053</td>
                            </tr>
                            <tr>
                                <td>54</td>
                                <td>Otoniel 54</td>
                                <td>Lopez 54</td>
                                <td>0424 0000054</td>
                            </tr>
                            <tr>
                                <td>55</td>
                                <td>Otoniel 55</td>
                                <td>Lopez 55</td>
                                <td>0424 0000055</td>
                            </tr>
                            <tr>
                                <td>56</td>
                                <td>Otoniel 56</td>
                                <td>Lopez 56</td>
                                <td>0424 0000056</td>
                            </tr>
                            <tr>
                                <td>57</td>
                                <td>Otoniel 57</td>
                                <td>Lopez 57</td>
                                <td>0424 0000057</td>
                            </tr>
                            <tr>
                                <td>58</td>
                                <td>Otoniel 58</td>
                                <td>Lopez 58</td>
                                <td>0424 0000058</td>
                            </tr>
                            <tr>
                                <td>59</td>
                                <td>Otoniel 59</td>
                                <td>Lopez 59</td>
                                <td>0424 0000059</td>
                            </tr>
                            <tr>
                                <td>60</td>
                                <td>Otoniel 60</td>
                                <td>Lopez 60</td>
                                <td>0424 0000060</td>
                            </tr>
                            <tr>
                                <td>61</td>
                                <td>Otoniel 61</td>
                                <td>Lopez 61</td>
                                <td>0424 0000061</td>
                            </tr>
                            <tr>
                                <td>62</td>
                                <td>Otoniel 62</td>
                                <td>Lopez 62</td>
                                <td>0424 0000062</td>
                            </tr>
                            <tr>
                                <td>63</td>
                                <td>Otoniel 63</td>
                                <td>Lopez 63</td>
                                <td>0424 0000063</td>
                            </tr>
                            <tr>
                                <td>64</td>
                                <td>Otoniel 64</td>
                                <td>Lopez 64</td>
                                <td>0424 0000064</td>
                            </tr>
                            <tr>
                                <td>65</td>
                                <td>Otoniel 65</td>
                                <td>Lopez 65</td>
                                <td>0424 0000065</td>
                            </tr>
                            <tr>
                                <td>66</td>
                                <td>Otoniel 66</td>
                                <td>Lopez 66</td>
                                <td>0424 0000066</td>
                            </tr>
                            <tr>
                                <td>67</td>
                                <td>Otoniel 67</td>
                                <td>Lopez 67</td>
                                <td>0424 0000067</td>
                            </tr>
                            <tr>
                                <td>68</td>
                                <td>Otoniel 68</td>
                                <td>Lopez 68</td>
                                <td>0424 0000068</td>
                            </tr>
                            <tr>
                                <td>69</td>
                                <td>Otoniel 69</td>
                                <td>Lopez 69</td>
                                <td>0424 0000069</td>
                            </tr>
                            <tr>
                                <td>70</td>
                                <td>Otoniel 70</td>
                                <td>Lopez 70</td>
                                <td>0424 0000070</td>
                            </tr>
                            <tr>
                                <td>71</td>
                                <td>Otoniel 71</td>
                                <td>Lopez 71</td>
                                <td>0424 0000071</td>
                            </tr>
                            <tr>
                                <td>72</td>
                                <td>Otoniel 72</td>
                                <td>Lopez 72</td>
                                <td>0424 0000072</td>
                            </tr>
                            <tr>
                                <td>73</td>
                                <td>Otoniel 73</td>
                                <td>Lopez 73</td>
                                <td>0424 0000073</td>
                            </tr>
                            <tr>
                                <td>74</td>
                                <td>Otoniel 74</td>
                                <td>Lopez 74</td>
                                <td>0424 0000074</td>
                            </tr>
                            <tr>
                                <td>75</td>
                                <td>Otoniel 75</td>
                                <td>Lopez 75</td>
                                <td>0424 0000075</td>
                            </tr>
                            <tr>
                                <td>76</td>
                                <td>Otoniel 76</td>
                                <td>Lopez 76</td>
                                <td>0424 0000076</td>
                            </tr>
                            <tr>
                                <td>77</td>
                                <td>Otoniel 77</td>
                                <td>Lopez 77</td>
                                <td>0424 0000077</td>
                            </tr>
                            <tr>
                                <td>78</td>
                                <td>Otoniel 78</td>
                                <td>Lopez 78</td>
                                <td>0424 0000078</td>
                            </tr>
                            <tr>
                                <td>79</td>
                                <td>Otoniel 79</td>
                                <td>Lopez 79</td>
                                <td>0424 0000079</td>
                            </tr>
                            <tr>
                                <td>80</td>
                                <td>Otoniel 80</td>
                                <td>Lopez 80</td>
                                <td>0424 0000080</td>
                            </tr>
                            <tr>
                                <td>81</td>
                                <td>Otoniel 81</td>
                                <td>Lopez 81</td>
                                <td>0424 0000081</td>
                            </tr>
                            <tr>
                                <td>82</td>
                                <td>Otoniel 82</td>
                                <td>Lopez 82</td>
                                <td>0424 0000082</td>
                            </tr>
                            <tr>
                                <td>83</td>
                                <td>Otoniel 83</td>
                                <td>Lopez 83</td>
                                <td>0424 0000083</td>
                            </tr>
                            <tr>
                                <td>84</td>
                                <td>Otoniel 84</td>
                                <td>Lopez 84</td>
                                <td>0424 0000084</td>
                            </tr>
                            <tr>
                                <td>85</td>
                                <td>Otoniel 85</td>
                                <td>Lopez 85</td>
                                <td>0424 0000085</td>
                            </tr>
                            <tr>
                                <td>86</td>
                                <td>Otoniel 86</td>
                                <td>Lopez 86</td>
                                <td>0424 0000086</td>
                            </tr>
                            <tr>
                                <td>87</td>
                                <td>Otoniel 87</td>
                                <td>Lopez 87</td>
                                <td>0424 0000087</td>
                            </tr>
                            <tr>
                                <td>88</td>
                                <td>Otoniel 88</td>
                                <td>Lopez 88</td>
                                <td>0424 0000088</td>
                            </tr>
                            <tr>
                                <td>89</td>
                                <td>Otoniel 89</td>
                                <td>Lopez 89</td>
                                <td>0424 0000089</td>
                            </tr>
                            <tr>
                                <td>90</td>
                                <td>Otoniel 90</td>
                                <td>Lopez 90</td>
                                <td>0424 0000090</td>
                            </tr>
                            <tr>
                                <td>91</td>
                                <td>Otoniel 91</td>
                                <td>Lopez 91</td>
                                <td>0424 0000091</td>
                            </tr>
                            <tr>
                                <td>92</td>
                                <td>Otoniel 92</td>
                                <td>Lopez 92</td>
                                <td>0424 0000092</td>
                            </tr>
                            <tr>
                                <td>93</td>
                                <td>Otoniel 93</td>
                                <td>Lopez 93</td>
                                <td>0424 0000093</td>
                            </tr>
                            <tr>
                                <td>94</td>
                                <td>Otoniel 94</td>
                                <td>Lopez 94</td>
                                <td>0424 0000094</td>
                            </tr>
                            <tr>
                                <td>95</td>
                                <td>Otoniel 95</td>
                                <td>Lopez 95</td>
                                <td>0424 0000095</td>
                            </tr>
                            <tr>
                                <td>96</td>
                                <td>Otoniel 96</td>
                                <td>Lopez 96</td>
                                <td>0424 0000096</td>
                            </tr>
                            <tr>
                                <td>97</td>
                                <td>Otoniel 97</td>
                                <td>Lopez 97</td>
                                <td>0424 0000097</td>
                            </tr>
                            <tr>
                                <td>98</td>
                                <td>Otoniel 98</td>
                                <td>Lopez 98</td>
                                <td>0424 0000098</td>
                            </tr>
                            <tr>
                                <td>99</td>
                                <td>Otoniel 99</td>
                                <td>Lopez 99</td>
                                <td>0424 0000099</td>
                            </tr>
                            <tr>
                                <td>100</td>
                                <td>Otoniel 100</td>
                                <td>Lopez 100</td>
                                <td>0424 0000100</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <br><br><br><br><br><br><br><br><br><br>
            </div>
        </main>
        
        <?php include_once "footer.php" ?>

        <!--JavaScript at end of body for optimized loading-->
        <script type="text/javascript" src="../assets/librerias/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="../assets/librerias/js/materialize.min.js"></script>
        <script type="text/javascript" src="../assets/librerias/js/datatables.min.js"></script>

        <!-- alertas -->
        <script type="text/javascript" src="../assets/librerias/js/sweetalert2.all.min.js"></script>
        <script type="text/javascript" src="../assets/js/repositorio.js"></script>
        <script>
            M.AutoInit();
        </script>
    </body>
</html>

<?php

function render($array){
    global $objAutor, $objLibro;
    foreach ($array as $index => $libro) {
        // fecha
        $fecha = Date("d-m-Y", strtotime($libro->fecha));
        $allAutores = $objAutor->getByLibroId($libro->id);
        $count = count($allAutores);
        $autores = "";

        foreach($allAutores as $key => $autor){
            $index = $key + 1;
            
            $autores = $autores . $autor->nombre;
            if( ( $count - $index) > 1){
                $autores = $autores . ", ";
            }else if(( $count - $index) == 1){
                $autores = $autores . " y ";
            }
        }

        // clasificacion (estrellas)
        $calificacion = $objLibro->getCalificacionByLibroId($libro->id);
        $x = "";

        $promedio = $calificacion->cantidad;
        if($promedio != null){
            for ($i=0; $i < 5; $i++) { 
                if($promedio >= 1) $x = $x . "<i class='material-icons yellow-text text-darken-1 '>star</i>";

                else if($promedio > 0 && $promedio < 1) $x = $x . "<i class='material-icons yellow-text text-darken-1 '>star_half</i>";

                else $x = $x . "<i class='material-icons yellow-text text-darken-1 '>star_border</i>";
                $promedio = $promedio - 1;
            }
        }else{
            $x = "Sin calificación";
        }
?>
<div class="col s12 libro">
    <div class="row valign-wrapper">
        <div class="col s0 m3 hide-on-small-only libro_imagen">
            <img src="../assets/images/libros/libro.png" alt="" class="responsive-img" width="70%">
        </div>

        <div class="col s12 m9  libro_datos">
            <h5 class="titulo teal-text valign-wrapper"><b><?= $libro->titulo ?></b>
            </h5>
            
            <div class="valign-wrapper">
                <b>Calificación: &nbsp;</b>
                <p><?= $x ?></p>
            </div>
            
            <div class="valign-wrapper">
                <b>Autor(es): &nbsp;</b>
                <p><?=  $autores ?></p>
            </div>
            
            <div class="valign-wrapper">
                <b>Editorial: &nbsp;</b>
                <p><?= $libro->editorial ?></p>
            </div>
            
            <div class="valign-wrapper">
                <b>Edicion: &nbsp;</b>
                <p><?= $libro->edicion ?></p>
            </div>

            <div class="valign-wrapper">
                <b>Fecha de pubicación: &nbsp;</b>
                <p><?= $fecha ?></p>
            </div>

            <div class="valign-wrapper">
                <b>Categoría: &nbsp;</b>
                <p><?= $libro->categoria ?></p>
            </div>

            <div class="valign-wrapper">
                <b>Carrera: &nbsp;</b>
                <p><?= $libro->carrera ?></p>
            </div>


            <div class="botones-accion ">
                <button class="btn-small waves-effect waves-light tooltipped" data-position="bottom" data-tooltip="Agregar a favoritos" style="margin-right: 5px;" onclick="agregarFavoritos(<?= $libro->id ?>)"><i class="material-icons ">star</i></button>
                <a href="<?= "libro.php?libro_id=" . $libro->id ?>" class="btn-small waves-effect waves-light tooltipped" data-position="bottom" data-tooltip="Ver detalles" target="_blank"><i class="material-icons">visibility</i></a>
            </div>
        </div>
    </div>
    <!-- <div class="row">
        <div class="col s12 m4">
            <button class="btn waves-effect waves-light">Prueba</button>
        </div>
        <div class="col s12 m4">
            <button class="btn waves-effect waves-light">Prueba</button>
        </div>
        <div class="col s12 m4">
            <button class="btn waves-effect waves-light">Prueba</button>
        </div>
    </div> -->
    <div class="divider"></div>
</div>
<?php
    }
}

