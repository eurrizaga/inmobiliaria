<?php
// src/AppBundle/Form/UserType.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', 'text')
            ->add('username', 'text')
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password')))
            ->add('administrar_unidades', 'checkbox', 
                    array('label' => 'Administrar Unidades', 
                            'required' => false
                        )
                )
            ->add('alquiler_cocheras', 'checkbox', 
                    array('label' => 'Alquiler/Reserva Cocheras', 
                        'required' => false
                        )
                )
            ->add('alquiler_departamentos', 'checkbox', 
                    array('label' => 'Alquiler/Reserva Departamentos', 
                            'required' => false
                        )
                )
            ->add('administrar_operaciones', 'checkbox', 
                    array('label' => 'Administrar Operaciones', 
                            'required' => false
                        )
                )
            ->add('ver_logs', 'checkbox', 
                    array('label' => 'Ver Logs', 
                            'required' => false
                        )
                )
            ->add('administrar_usuarios', 'checkbox', 
                    array('label' => 'Administrar Usuarios', 
                        'required' => false
                    )
                )
            ->add('caja', 'choice', array('choices' => array('1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5)));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Usuario'
        ));
    }

    public function getName()
    {
        return 'usuario';
    }
}