
import { useState } from 'react';
import { Route as RouteIcon, MapPin, Clock, Search } from 'lucide-react';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Badge } from '@/components/ui/badge';
import { Separator } from '@/components/ui/separator';
import { mockRoutes, mockBusLines, mockBusStops } from '@/data/mockData';
import { Route, BusLine, BusStop } from '@/types';

const Routes = () => {
  const [routes] = useState<Route[]>(mockRoutes);
  const [busLines] = useState<BusLine[]>(mockBusLines);
  const [busStops] = useState<BusStop[]>(mockBusStops);
  const [searchTerm, setSearchTerm] = useState('');
  const [selectedFilter, setSelectedFilter] = useState<'all' | 'line' | 'stop'>('all');
  const [selectedLineId, setSelectedLineId] = useState<string>('');
  const [selectedStopId, setSelectedStopId] = useState<string>('');

  const getFilteredRoutes = () => {
    let filtered = routes;

    // Filtro por busca textual
    if (searchTerm) {
      filtered = filtered.filter(route =>
        route.busLine?.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
        route.busLine?.number.toLowerCase().includes(searchTerm.toLowerCase()) ||
        route.busStops.some(stop => 
          stop.name.toLowerCase().includes(searchTerm.toLowerCase())
        )
      );
    }

    // Filtro por linha específica
    if (selectedFilter === 'line' && selectedLineId) {
      filtered = filtered.filter(route => route.busLineId === selectedLineId);
    }

    // Filtro por ponto específico
    if (selectedFilter === 'stop' && selectedStopId) {
      filtered = filtered.filter(route =>
        route.busStops.some(stop => stop.id === selectedStopId)
      );
    }

    return filtered;
  };

  const filteredRoutes = getFilteredRoutes();

  return (
    <div className="space-y-6">
      {/* Header */}
      <div className="flex justify-between items-center">
        <div>
          <h1 className="text-3xl font-bold text-foreground">Itinerários</h1>
          <p className="text-muted-foreground">Consulte rotas por linha ou por ponto de ônibus</p>
        </div>
      </div>

      {/* Filters */}
      <div className="space-y-4">
        {/* Search */}
        <div className="relative">
          <Search className="absolute left-3 top-3 h-4 w-4 text-muted-foreground" />
          <Input
            placeholder="Buscar por linha ou ponto..."
            value={searchTerm}
            onChange={(e) => setSearchTerm(e.target.value)}
            className="pl-10"
          />
        </div>

        {/* Filter Type */}
        <div className="flex flex-wrap gap-4 items-center">
          <div className="flex items-center space-x-2">
            <label className="text-sm font-medium">Filtrar por:</label>
            <Select value={selectedFilter} onValueChange={(value: 'all' | 'line' | 'stop') => {
              setSelectedFilter(value);
              setSelectedLineId('');
              setSelectedStopId('');
            }}>
              <SelectTrigger className="w-40">
                <SelectValue />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="all">Todos</SelectItem>
                <SelectItem value="line">Linha específica</SelectItem>
                <SelectItem value="stop">Ponto específico</SelectItem>
              </SelectContent>
            </Select>
          </div>

          {selectedFilter === 'line' && (
            <Select value={selectedLineId} onValueChange={setSelectedLineId}>
              <SelectTrigger className="w-60">
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
          )}

          {selectedFilter === 'stop' && (
            <Select value={selectedStopId} onValueChange={setSelectedStopId}>
              <SelectTrigger className="w-60">
                <SelectValue placeholder="Selecione um ponto" />
              </SelectTrigger>
              <SelectContent>
                {busStops.map((stop) => (
                  <SelectItem key={stop.id} value={stop.id}>
                    {stop.name}
                  </SelectItem>
                ))}
              </SelectContent>
            </Select>
          )}
        </div>
      </div>

      {/* Routes List */}
      <div className="space-y-4">
        {filteredRoutes.map((route) => (
          <Card key={route.id} className="hover:shadow-lg transition-shadow">
            <CardHeader>
              <div className="flex items-center justify-between">
                <div className="flex items-center space-x-3">
                  <RouteIcon className="h-6 w-6 text-primary" />
                  <div>
                    <CardTitle className="text-xl">
                      Linha {route.busLine?.number} - {route.busLine?.name}
                    </CardTitle>
                    <CardDescription className="flex items-center space-x-2">
                      <Clock className="h-4 w-4" />
                      <span>Duração estimada: {route.estimatedDuration} minutos</span>
                    </CardDescription>
                  </div>
                </div>
                <Badge 
                  style={{ 
                    backgroundColor: route.busLine?.color + '20',
                    color: route.busLine?.color,
                    borderColor: route.busLine?.color
                  }}
                  variant="outline"
                >
                  {route.direction === 'outbound' ? 'Ida' : 'Volta'}
                </Badge>
              </div>
            </CardHeader>
            <CardContent>
              <div className="space-y-4">
                <div>
                  <h4 className="font-medium mb-3 flex items-center">
                    <MapPin className="h-4 w-4 mr-2" />
                    Pontos do Itinerário ({route.busStops.length} paradas)
                  </h4>
                  <div className="space-y-2">
                    {route.busStops.map((stop, index) => (
                      <div key={stop.id} className="flex items-center space-x-3">
                        <div className="flex items-center justify-center w-6 h-6 rounded-full bg-primary text-primary-foreground text-xs font-medium">
                          {index + 1}
                        </div>
                        <div className="flex-1">
                          <div className="font-medium">{stop.name}</div>
                          <div className="text-sm text-muted-foreground">{stop.address}</div>
                        </div>
                        <div className="text-xs text-muted-foreground">
                          {stop.latitude.toFixed(4)}, {stop.longitude.toFixed(4)}
                        </div>
                      </div>
                    ))}
                  </div>
                </div>

                <Separator />

                <div className="text-sm text-muted-foreground">
                  {route.busLine?.description}
                </div>
              </div>
            </CardContent>
          </Card>
        ))}
      </div>

      {filteredRoutes.length === 0 && (
        <div className="text-center py-12">
          <RouteIcon className="h-12 w-12 text-muted-foreground mx-auto mb-4" />
          <h3 className="text-lg font-medium text-foreground mb-2">
            Nenhum itinerário encontrado
          </h3>
          <p className="text-muted-foreground">
            {searchTerm || selectedFilter !== 'all' 
              ? 'Tente ajustar os filtros de busca' 
              : 'Nenhum itinerário cadastrado no sistema'
            }
          </p>
        </div>
      )}
    </div>
  );
};

export default Routes;
