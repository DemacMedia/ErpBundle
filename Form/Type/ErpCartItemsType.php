<?php

namespace DemacMedia\Bundle\ErpBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ErpCartItemsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'cart_item_number',
                'number',
                [
                    'required' => true,
                    'label'    => 'Original Cart Item ID'
                ]
            )
            ->add(
                'sku',
                'text',
                [
                    'required'    => true,
                    'label'       => 'Sku',
                ]
            )
            ->add(
                'product_name',
                'text',
                [
                    'required'    => false,
                    'label'       => 'Product Name',
                ]
            )
            ->add(
                'product_price',
                'oro_money',
                [
                    'required'    => false,
                    'label'       => 'Product Price',
                ]
            )
            ->add(
                'quantity',
                'number',
                [
                    'required'    => true,
                    'label'       => 'Quantity',
                ]
            )
            ->add(
                'created_at',
                'oro_datetime',
                [
                    'required'    => true,
                    'label'       => 'Created At',
                ]
            )
            ->add(
                'updated_at',
                'oro_datetime',
                [
                    'required'    => true,
                    'label'       => 'Updated At',
                ]
            )
            ->add(
                'website_id',
                'text',
                [
                    'required'    => true,
                    'label'       => 'Website ID',
                ]
            )
            ->add(
                'cart',
                null,
                [
                    'required' => true,
                    'label' => 'Cart ID'
                ]
            )
            ->add(
                'owner',
                'translatable_entity',
                [
                    'class'    => 'Oro\Bundle\UserBundle\Entity\User',
                    'property' => 'username',
                    'required' => false
                ]
            );
    }


    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'           => 'DemacMedia\Bundle\ErpBundle\Entity\OroErpCartItems',
                'csrf_protection'      => false,
                'cascade_validation'   => false,
                'extra_fields_message' => 'EXTRA FIELDS DETECTED! "{{ extra_fields }}"',
            ]
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'demacmedia_erp_cartitems';
    }
}
