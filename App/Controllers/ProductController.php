<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\ConvertPrice;
use App\Models\ProductModel;
use App\Core\View;
use App\Helpers\product\ExtractData;
use App\Helpers\ConvertDate;
use App\Helpers\ValidateRequest;
use App\Helpers\RedirectWithMessage;

/**
 * Controlador responsável por gerenciar as requisições relacionadas aos produtos.
 *
 * Este controlador lida com a exibição de produtos, criação, atualização e
 * exclusão de produtos, além de fornecer a lógica necessária para
 * interagir com o modelo de produtos (ProductModel) e renderizar as
 * respectivas views.
 */
class ProductController extends Controller
{
    // Instância da ProductModel.
    private $productModel;

    /**
     * Verifica se o usuário está logado e instância a model.
     */
    public function __construct()
    {
        parent::__construct();

        $this->productModel = new ProductModel();
    }

    public function index(): void
    {

    }

    /**
     * Exibe o formulário para cadastrar um novo produto.
     *
     * @return void
     */
    public function create(): void
    {
        View::render('/product/create');
    }

    /**
     * Armazena um novo produto no banco de dados.
     *
     * Redireciona para a página de produtos.
     *
     * @return void
     */
    public function store(): void
    {
        // Verifica se a requisição é valida.
        ValidateRequest::handle('/produto/cadastrar');

        // Extrai e formata os dados do formulário.
        $productData = $this->processProductData($_POST);

        // Verifica se o produto já está cadastrado.
        $this->productExists($productData);

        // Cadastra um novo produto.
        $this->productModel->create($productData);

        RedirectWithMessage::handle(BASE_URL . '/produto/todos', FLASH_SUCCESS, 'Produto <b>cadastrado</b> com sucesso!');
    }

    /**
     * Exibe todos os produtos cadastrados.
     *
     * @return void
     */
    public function show(): void
    {
        // Armazena os dados de todos produtos.
        $productsData = $this->productModel->getAll();

        // Renderiza a view, passando os dados.
        View::render('/product/show', $productsData);
    }

    /**
     * Exibe o formulário para editar um produto pelo ID informado
     *
     * @param integer $id ID do produto.
     * @return void
     */
    public function edit(int $id): void
    {
        // Armazena os dados do produto encontrado.
        $productsData = $this->productModel->getById($id);

        // Se o produto não for encontrado, redireciona e exibe a flash message.
        if (!$productsData) {
            RedirectWithMessage::handle(BASE_URL . '/product/show', FLASH_ERROR, 'Produto não foi <b>econtrado</b>!');
        }

        // Converte a data de cadastro do produto para formato pt_BR.
        $productsData->created_at = ConvertDate::handle($productsData->created_at);

        // Renderiza a view, passando os dados.
        View::render('/product/edit', $productsData);
    }

    /**
     * Atualiza um produto existente no banco de dados.
     *
     * Redireciona para o formulário de edição após a atualização.
     *
     * @return void
     */
    public function update(): void
    {
        // Verifica se a requisição é valida.
        ValidateRequest::handle(BASE_URL . '/produto/todos');

        // Extrai e formata os dados do formulário.
        $productData = $this->processProductData($_POST);

        // Atualiza os dados do produto.
        $this->productModel->update($productData);

        RedirectWithMessage::handle(BASE_URL . "/produto/editar/{$productData->id}", FLASH_INFO, 'Produto <b>editado</b> com sucesso!');
    }

    /**
     * Remove um produto no banco de dados.
     *
     * Redireciona para a página todos os produtos após a exclusão.
     *
     * @param integer $id ID do produto.
     * @return void
     */
    public function delete(int $id): void
    {
        // Deleta o produto.
        $result = $this->productModel->delete($id);

        // Se o produto não for encontrado, redireciona e exibe a flash message.
        if ($result != true) {
            RedirectWithMessage::handle(BASE_URL . '/produto/todos', FLASH_ERROR, 'Produto não foi <b>econtrado</b>!');
        }

        RedirectWithMessage::handle(BASE_URL . '/produto/todos', FLASH_WARNING, 'Produto <b>excluído</b> com sucesso!');
    }

    /**
     * Extrai os dados do formulário e formata os dados para armazenar no banco de dados.
     *
     * @param array $data Dados do produto.
     * @return object
     */
    private function processProductData(array $data): object
    {
        // Extrai os dados.
        $productData = ExtractData::handle($data);

        // Formata o valor monetário para en_US.
        $productData->sell_price = ConvertPrice::handle($productData->sell_price);
        $productData->cost_price = ConvertPrice::handle($productData->cost_price);

        return $productData;
    }

    /**
     * Verifica se o produto já está cadastrado.
     *
     * @param object $data Dados do produto.
     * @return void
     */
    private function productExists(object $data): void
    {
        if ($data->name != null) {
            if ($this->productModel->productExists($data->name)) {
                RedirectWithMessage::handle(BASE_URL . '/produto/cadastrar', FLASH_ERROR, 'Já existe um produto com esse <b>Nome</b>.');
            }
        }
    }

    /**
     * Retorna todos os produtos para o Ajax de produtos.
     * @return void
     */
    public function products(): void
    {
        $data = $this->productModel->getAll();
        $data = (array) $data;
        echo json_encode($data);
    }
}
