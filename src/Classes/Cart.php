<?php
namespace App\Classes;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;


class Cart
{
    private $entityManager;
    private $requestStack;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager)
    {
        $this->requestStack = $requestStack->getSession();
        $this-> entityManager = $entityManager;
        
    }

    public function add($id)
    {
        $cart = $this->requestStack ->get('cart',[]);

        if (!empty ($cart[$id])){
            $cart[$id]++;
        }else{
            $cart[$id] = 1;
        }
        $this->requestStack->set('cart', $cart);
    }

    public function decrease($id)
    {
        $cart = $this->requestStack ->get('cart',[]);

        if ($cart[$id]>1){
            $cart[$id]--;
        }else{
            unset($cart[$id]);
        }
        $this->requestStack->set('cart', $cart);
    }
    
    public function get()
    {
        return $this->requestStack->get('cart');
    }

    public function remove()
    {      
        return $this->requestStack->remove('cart');
    }

    public function delete($id)
    {
    $cart = $this->requestStack ->get('cart',[]);
        unset($cart[$id]);
        
        return $this->requestStack->set('cart', $cart);
    }


    public function getFull()
    {
        
        $cartContent = [];
        if($this -> get())
        {        
        foreach($this->get() as $id => $quantity){
            $product_object = $this->entityManager->getRepository(Product::class)->findOneBy(['id' => $id]);
            if (!$product_object){
                $this->delete($id);
                continue;
            }
            $cartContent[] = [
                'product' => $product_object,
                'quantity' => $quantity   
            ];
        }            
            return $cartContent;
        }
    }
}
