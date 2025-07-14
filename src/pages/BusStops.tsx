
import { useState } from 'react';
import { Plus, MapPin, Edit, Trash2, Search } from 'lucide-react';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Badge } from '@/components/ui/badge';
import { useToast } from '@/hooks/use-toast';
import { mockBusStops } from '@/data/mockData';
import { BusStop } from '@/types';

const BusStops = () => {
  const [busStops, setBusStops] = useState<BusStop[]>(mockBusStops);
  const [searchTerm, setSearchTerm] = useState('');
  const [isAddDialogOpen, setIsAddDialogOpen] = useState(false);
  const [formData, setFormData] = useState({
    name: '',
    description: '',
    latitude: '',
    longitude: '',
    address: ''
  });
  const { toast } = useToast();

  const filteredBusStops = busStops.filter(stop =>
    stop.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
    stop.address.toLowerCase().includes(searchTerm.toLowerCase())
  );

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    
    if (!formData.name || !formData.latitude || !formData.longitude || !formData.address) {
      toast({
        title: "Erro de validação",
        description: "Por favor, preencha todos os campos obrigatórios.",
        variant: "destructive"
      });
      return;
    }

    const newBusStop: BusStop = {
      id: Date.now().toString(),
      name: formData.name,
      description: formData.description,
      latitude: parseFloat(formData.latitude),
      longitude: parseFloat(formData.longitude),
      address: formData.address,
      createdAt: new Date()
    };

    setBusStops([...busStops, newBusStop]);
    setFormData({ name: '', description: '', latitude: '', longitude: '', address: '' });
    setIsAddDialogOpen(false);
    
    toast({
      title: "Sucesso!",
      description: "Ponto de ônibus cadastrado com sucesso.",
    });
  };

  const handleDelete = (id: string, name: string) => {
    setBusStops(busStops.filter(stop => stop.id !== id));
    toast({
      title: "Ponto removido",
      description: `O ponto "${name}" foi removido com sucesso.`,
    });
  };

  return (
    <div className="space-y-6">
      {/* Header */}
      <div className="flex justify-between items-center">
        <div>
          <h1 className="text-3xl font-bold text-foreground">Pontos de Ônibus</h1>
          <p className="text-muted-foreground">Gerencie os pontos de ônibus do sistema</p>
        </div>
        
        <Dialog open={isAddDialogOpen} onOpenChange={setIsAddDialogOpen}>
          <DialogTrigger asChild>
            <Button className="flex items-center space-x-2">
              <Plus className="h-4 w-4" />
              <span>Cadastrar Ponto</span>
            </Button>
          </DialogTrigger>
          <DialogContent className="sm:max-w-[500px]">
            <DialogHeader>
              <DialogTitle>Cadastrar Novo Ponto</DialogTitle>
              <DialogDescription>
                Preencha as informações do ponto de ônibus
              </DialogDescription>
            </DialogHeader>
            <form onSubmit={handleSubmit} className="space-y-4">
              <div>
                <Label htmlFor="name">Nome do Ponto *</Label>
                <Input
                  id="name"
                  value={formData.name}
                  onChange={(e) => setFormData({...formData, name: e.target.value})}
                  placeholder="Ex: Terminal Central"
                />
              </div>
              
              <div>
                <Label htmlFor="address">Endereço *</Label>
                <Input
                  id="address"
                  value={formData.address}
                  onChange={(e) => setFormData({...formData, address: e.target.value})}
                  placeholder="Ex: Rua das Flores, 123"
                />
              </div>
              
              <div className="grid grid-cols-2 gap-4">
                <div>
                  <Label htmlFor="latitude">Latitude *</Label>
                  <Input
                    id="latitude"
                    type="number"
                    step="any"
                    value={formData.latitude}
                    onChange={(e) => setFormData({...formData, latitude: e.target.value})}
                    placeholder="-23.5505"
                  />
                </div>
                <div>
                  <Label htmlFor="longitude">Longitude *</Label>
                  <Input
                    id="longitude"
                    type="number"
                    step="any"
                    value={formData.longitude}
                    onChange={(e) => setFormData({...formData, longitude: e.target.value})}
                    placeholder="-46.6333"
                  />
                </div>
              </div>
              
              <div>
                <Label htmlFor="description">Descrição</Label>
                <Textarea
                  id="description"
                  value={formData.description}
                  onChange={(e) => setFormData({...formData, description: e.target.value})}
                  placeholder="Descrição opcional do ponto"
                />
              </div>
              
              <Button type="submit" className="w-full">Cadastrar Ponto</Button>
            </form>
          </DialogContent>
        </Dialog>
      </div>

      {/* Search */}
      <div className="relative">
        <Search className="absolute left-3 top-3 h-4 w-4 text-muted-foreground" />
        <Input
          placeholder="Buscar pontos por nome ou endereço..."
          value={searchTerm}
          onChange={(e) => setSearchTerm(e.target.value)}
          className="pl-10"
        />
      </div>

      {/* Bus Stops Grid */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {filteredBusStops.map((stop) => (
          <Card key={stop.id} className="hover:shadow-lg transition-shadow">
            <CardHeader>
              <div className="flex items-start justify-between">
                <div className="flex items-center space-x-2">
                  <MapPin className="h-5 w-5 text-primary" />
                  <CardTitle className="text-lg">{stop.name}</CardTitle>
                </div>
                <div className="flex space-x-2">
                  <Button variant="ghost" size="sm">
                    <Edit className="h-4 w-4" />
                  </Button>
                  <Button 
                    variant="ghost" 
                    size="sm"
                    onClick={() => handleDelete(stop.id, stop.name)}
                  >
                    <Trash2 className="h-4 w-4 text-destructive" />
                  </Button>
                </div>
              </div>
              <CardDescription>{stop.address}</CardDescription>
            </CardHeader>
            <CardContent className="space-y-3">
              {stop.description && (
                <p className="text-sm text-muted-foreground">{stop.description}</p>
              )}
              
              <div className="flex flex-wrap gap-2">
                <Badge variant="secondary">
                  Lat: {stop.latitude.toFixed(4)}
                </Badge>
                <Badge variant="secondary">
                  Lng: {stop.longitude.toFixed(4)}
                </Badge>
              </div>
              
              <div className="text-xs text-muted-foreground">
                Cadastrado em {stop.createdAt.toLocaleDateString('pt-BR')}
              </div>
            </CardContent>
          </Card>
        ))}
      </div>

      {filteredBusStops.length === 0 && (
        <div className="text-center py-12">
          <MapPin className="h-12 w-12 text-muted-foreground mx-auto mb-4" />
          <h3 className="text-lg font-medium text-foreground mb-2">
            Nenhum ponto encontrado
          </h3>
          <p className="text-muted-foreground">
            {searchTerm ? 'Tente uma busca diferente' : 'Cadastre o primeiro ponto de ônibus'}
          </p>
        </div>
      )}
    </div>
  );
};

export default BusStops;
