
import { Bus } from 'lucide-react';
import { Link, useLocation } from 'react-router-dom';

const Header = () => {
  const location = useLocation();
  
  return (
    <header className="bg-white shadow-sm border-b">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between items-center h-16">
          <Link to="/" className="flex items-center space-x-3">
            <div className="bg-primary p-2 rounded-lg">
              <Bus className="h-6 w-6 text-primary-foreground" />
            </div>
            <div>
              <h1 className="text-xl font-bold text-foreground">Ônibus em Rota</h1>
              <p className="text-xs text-muted-foreground">Sistema de Gestão de Transporte</p>
            </div>
          </Link>
          
          <nav className="hidden md:flex space-x-8">
            <Link 
              to="/" 
              className={`text-sm font-medium transition-colors hover:text-primary ${
                location.pathname === '/' ? 'text-primary' : 'text-muted-foreground'
              }`}
            >
              Início
            </Link>
            <Link 
              to="/pontos" 
              className={`text-sm font-medium transition-colors hover:text-primary ${
                location.pathname === '/pontos' ? 'text-primary' : 'text-muted-foreground'
              }`}
            >
              Pontos
            </Link>
            <Link 
              to="/veiculos" 
              className={`text-sm font-medium transition-colors hover:text-primary ${
                location.pathname === '/veiculos' ? 'text-primary' : 'text-muted-foreground'
              }`}
            >
              Veículos
            </Link>
            <Link 
              to="/itinerarios" 
              className={`text-sm font-medium transition-colors hover:text-primary ${
                location.pathname === '/itinerarios' ? 'text-primary' : 'text-muted-foreground'
              }`}
            >
              Itinerários
            </Link>
          </nav>
        </div>
      </div>
    </header>
  );
};

export default Header;
