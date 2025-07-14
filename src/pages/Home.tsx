
import { MapPin, Bus, Route, BarChart3 } from 'lucide-react';
import { Link } from 'react-router-dom';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';

const Home = () => {
  const features = [
    {
      title: 'Pontos de Ônibus',
      description: 'Cadastre e gerencie pontos de ônibus com localização geográfica precisa',
      icon: MapPin,
      href: '/pontos',
      color: 'text-blue-600',
      bgColor: 'bg-blue-50'
    },
    {
      title: 'Veículos e Linhas',
      description: 'Registre veículos e vincule-os às linhas de transporte',
      icon: Bus,
      href: '/veiculos',
      color: 'text-green-600',
      bgColor: 'bg-green-50'
    },
    {
      title: 'Itinerários',
      description: 'Consulte rotas por ponto ou por linha de ônibus',
      icon: Route,
      href: '/itinerarios',
      color: 'text-purple-600',
      bgColor: 'bg-purple-50'
    }
  ];

  return (
    <div className="space-y-8">
      {/* Hero Section */}
      <div className="text-center space-y-4">
        <h1 className="text-4xl font-bold text-foreground">
          Sistema de Gestão de Transporte Público
        </h1>
        <p className="text-xl text-muted-foreground max-w-2xl mx-auto">
          Gerencie pontos de ônibus, veículos, linhas e itinerários de forma simples e eficiente.
          Desenvolvido para fins acadêmicos com foco na usabilidade.
        </p>
      </div>

      {/* Feature Cards */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {features.map((feature) => {
          const Icon = feature.icon;
          return (
            <Card key={feature.title} className="hover:shadow-lg transition-shadow duration-300 animate-slide-up">
              <CardHeader className="text-center">
                <div className={`w-16 h-16 ${feature.bgColor} rounded-full flex items-center justify-center mx-auto mb-4`}>
                  <Icon className={`h-8 w-8 ${feature.color}`} />
                </div>
                <CardTitle className="text-lg">{feature.title}</CardTitle>
                <CardDescription className="text-sm">
                  {feature.description}
                </CardDescription>
              </CardHeader>
              <CardContent>
                <Button asChild className="w-full">
                  <Link to={feature.href}>
                    Acessar
                  </Link>
                </Button>
              </CardContent>
            </Card>
          );
        })}
      </div>

      {/* Stats Section */}
      <div className="bg-white rounded-lg shadow-sm border p-8">
        <h2 className="text-2xl font-semibold text-center mb-8">Visão Geral do Sistema</h2>
        <div className="grid grid-cols-1 md:grid-cols-4 gap-8">
          <div className="text-center">
            <div className="text-3xl font-bold text-primary">3</div>
            <div className="text-sm text-muted-foreground">Pontos Cadastrados</div>
          </div>
          <div className="text-center">
            <div className="text-3xl font-bold text-primary">2</div>
            <div className="text-sm text-muted-foreground">Linhas Ativas</div>
          </div>
          <div className="text-center">
            <div className="text-3xl font-bold text-primary">3</div>
            <div className="text-sm text-muted-foreground">Veículos Registrados</div>
          </div>
          <div className="text-center">
            <div className="text-3xl font-bold text-primary">2</div>
            <div className="text-sm text-muted-foreground">Rotas Configuradas</div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Home;
