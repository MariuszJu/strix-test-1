<?php

namespace StrixTask\Model\Repository\Factory;

use StrixTask\Model\Repository\TripMeasureRepository;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use StrixTask\Model\Helper\Inflector;
use Zend\Db\TableGateway\TableGateway;
use Interop\Container\ContainerInterface;
use StrixTask\Model\Repository\TripRepository;
use Zend\ServiceManager\Factory\AbstractFactoryInterface;

class AbstractRepositoryFactory implements AbstractFactoryInterface
{

    /** @var array */
    protected $services = [
        TripRepository::class, TripMeasureRepository::class,
    ];

    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @return bool
     */
    public function canCreate(ContainerInterface $container, $requestedName): bool
    {
        return in_array($requestedName, $this->services);
    }

    /**
     * @throws \Zend\Db\TableGateway\Exception\InvalidArgumentException
     * @throws \Zend\Db\ResultSet\Exception\InvalidArgumentException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \RuntimeException
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     * @return object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $classParts = explode('\\', $requestedName);
        $repositoryClass = end($classParts);

        if (strpos($repositoryClass, 'Repository') === false) {
            throw new \RuntimeException('Unable to create valid Repository class');
        }
        
        $entityClass = str_replace('Repository', '', $repositoryClass);
        $entityNamespace = str_replace('Repository', 'Entity',
            substr($requestedName, 0, strpos($requestedName, $repositoryClass))
        ) . $entityClass;
        
        if (!class_exists($entityNamespace)) {
            throw new \RuntimeException(sprintf('Entity class %s does not exist', $entityNamespace));
        }
        
        $dbAdapter = $container->get(Adapter::class);
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new $entityNamespace());
        $tableGateway = new TableGateway(Inflector::to_underscore($entityClass) . 's', $dbAdapter, null, $resultSetPrototype);

        $dbName = $container->get('configuration')['db']['database'] ?? null;
        
        $entityTable = new $requestedName($tableGateway, $dbName);
        return $entityTable;
    }

}
