
import { useState } from 'react';
import { Plus, Bus, Edit, Trash2, Search } from 'lucide-react';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Badge } from '@/components/ui/badge';
import { useToast } from '@/hooks/use-toast';
import { mockVehicles, mockBusLines } from '@/data/mockData';
import { Vehicle, BusLine } from '@/types';

const Vehicles = () => {
  const [vehicles, setVehicles] = useState<Vehicle[]>(mockVehicles);
  const [busLines] = useState<BusLine[]>(mockBusLines);
  const [searchTerm, setSearchTerm] = useState('');
  const [isAddDialogOpen, setIsAddDialogOpen] = useState(false);
  const [formData, setFormData] = useState({
    plateNumber: '',
    model: '',
    capacity: '',
    busLineId: ''
  });
  const { toast } = useToast();

  const filteredVehicles = vehicles.filter(vehicle =>
    vehicle.plateNumber.toLowerCase().includes(searchTerm.toLowerCase()) ||
    vehicle.model.toLowerCase().includes(searchTerm.toLowerCase()) ||
    vehicle.busLine?.name.toLowerCase().includes(searchTerm.toLowerCase())
  );

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    
    if (!formData.plateNumber || !formData.model || !formData.capacity || !formData.busLineId) {
      toast({
        title: "Erro de validação",
        description: "Por favor, preencha todos os campos obrigatórios.",
        variant: "destructive"
      });
      return;
    }

    const selectedBusLine = busLines.find(line => line.id === formData.busLineId);
    
    const newVehicle: Vehicle = {
      id: Date.now().toString(),
      plateNumber: formData.plateNumber.toUpperCase(),
      model: formData.model,
      capacity: parseInt(formData.capacity),
      busLineId: formData.busLineId,
      busLine: selectedBusLine,
      createdAt: new Date()
    };

    setVehicles([...vehicles, newVehicle]);
    setFormData({ plateNumber: '', model: '', capacity: '', busLineId: '' });
    setIsAddDialogOpen(false);
    
    toast({
      title: "Sucesso!",
      description: "Veículo cadastrado com sucesso.",
    });
  };

  const handleDelete = (id: string, plateNumber: string) => {
    setVehicles(vehicles.filter(vehicle => vehicle.id !== id));
    toast({
      title: "Veículo removido",
      description: `O veículo ${plateNumber} foi removido com sucesso.`,
    });
  };

  return (
    <div className="space-y-6">
      {/* Header */}
      <div className="flex justify-between items-center">
        <div>
          <h1 className="text-3xl font-bold text-foreground">Veículos</h1>
          <p className="text-muted-foreground">Gerencie os veículos e suas vinculações com linhas</p>
        </div>
        
        <Dialog open={isAddDialogOpen} onOpenChange={setIsAddDialogOpen}>
          <DialogTrigger asChild>
            <Button className="flex items-center space-x-2">
              <Plus className="h-4 w-4" />
              <span>Cadastrar Veículo</span>
            </Button>
          </DialogTrigger>
          <DialogContent className="sm:max-w-[500px]">
            <DialogHeader>
              <DialogTitle>Cadastrar Novo Veículo</DialogTitle>
              <DialogDescription>
                Preencha as informações do veículo e vincule-o a uma linha
              </DialogDescription>
            </DialogHeader>
            <form onSubmit={handleSubmit} className="space-y-4">
              <div>
                <Label htmlFor="plateNumber">Placa do Veículo *</Label>
                <Input
                  id="plateNumber"
                  value={formData.plateNumber}
                  onChange={(e) => setFormData({...formData, plateNumber: e.target.value})}
                  placeholder="Ex: ABC-1234"
                  maxLength={8}
                />
              </div>
              
              <div>
                <Label htmlFor="model">Modelo *</Label>
                <Input
                  id="model"
                  value={formData.model}
                  onChange={(e) => setFormData({...formData, model: e.target.value})}
                  placeholder="Ex: Mercedes-Benz OF-1721"
                />
              </div>
              
              <div>
                <Label htmlFor="capacity">Capacidade *</Label>
                <Input
                  id="capacity"
                  type="number"
                  value={formData.capacity}
                  onChange={(e) => setFormData({...formData, capacity: e.target.value})}
                  placeholder="Ex: 80"
                  min="1"
                />
              </div>
              
              <div>
                <Label htmlFor="busLine">Linha de Ônibus *</Label>
                <Select onValueChange={(value) => setFormData({...formData, busLineId: value})}>
                  <SelectTrigger>
                    <SelectValue placeholder="Selecione uma linha" />
                  </SelectTrigger>
                  <SelectContent>
                    {busLines.map((line) => (
                      <SelectItem key={line.id} value={line.id}>
                        {line.number} - {line.name}
                      </SelectItem>
                    ))}
                  </SelectContent>
                </Select>
              </div>
              
              <Button type="submit" className="w-full">Cadastrar Veículo</Button>
            </form>
          </DialogContent>
        </Dialog>
      </div>

      {/* Search */}
      <div className="relative">
        <Search className="absolute left-3 top-3 h-4 w-4 text-muted-foreground" />
        <Input
          placeholder="Buscar veículos por placa, modelo ou linha..."
          value={searchTerm}
          onChange={(e) => setSearchTerm(e.target.value)}
          className="pl-10"
        />
      </div>

      {/* Vehicles Grid */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {filteredVehicles.map((vehicle) => (
          <Card key={vehicle.id} className="hover:shadow-lg transition-shadow">
            <CardHeader>
              <div className="flex items-start justify-between">
                <div className="flex items-center space-x-2">
                  <Bus className="h-5 w-5 text-primary" />
                  <CardTitle className="text-lg">{vehicle.plateNumber}</CardTitle>
                </div>
                <div className="flex space-x-2">
                  <Button variant="ghost" size="sm">
                    <Edit className="h-4 w-4" />
                  </Button>
                  <Button 
                    variant="ghost" 
                    size="sm"
                    onClick={() => handleDelete(vehicle.id, vehicle.plateNumber)}
                  >
                    <Trash2 className="h-4 w-4 text-destructive" />
                  </Button>
                </div>
              </div>
              <CardDescription>{vehicle.model}</CardDescription>
            </CardHeader>
            <CardContent className="space-y-3">
              <div className="flex items-center justify-between">
                <span className="text-sm font-medium">Capacidade:</span>
                <Badge variant="secondary">{vehicle.capacity} passageiros</Badge>
              </div>
              
              <div className="flex items-center justify-between">
                <span className="text-sm font-medium">Linha:</span>
                <Badge 
                  style={{ 
                    backgroundColor: vehicle.busLine?.color + '20',
                    color: vehicle.busLine?.color,
                    borderColor: vehicle.busLine?.color
                  }}
                  variant="outline"
                >
                  {vehicle.busLine?.number} - {vehicle.busLine?.name}
                </Badge>
              </div>
              
              <div className="text-xs text-muted-foreground">
                Cadastrado em {vehicle.createdAt.toLocaleDateString('pt-BR')}
              </div>
              
              <Button variant="outline" className="w-full">
                Ver Detalhes
              </Button>
            </CardContent>
          </Card>
        ))}
      </div>

      {filteredVehicles.length === 0 && (
        <div className="text-center py-12">
          <Bus className="h-12 w-12 text-muted-foreground mx-auto mb-4" />
          <h3 className="text-lg font-medium text-foreground mb-2">
            Nenhum veículo encontrado
          </h3>
          <p className="text-muted-foreground">
            {searchTerm ? 'Tente uma busca diferente' : 'Cadastre o primeiro veículo'}
          </p>
        </div>
      )}
    </div>
  );
};

export default Vehicles;
