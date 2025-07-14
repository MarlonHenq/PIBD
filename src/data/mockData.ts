
import { BusStop, BusLine, Vehicle, Route } from '@/types';

export const mockBusStops: BusStop[] = [
  {
    id: '1',
    name: 'Terminal Central',
    description: 'Principal terminal de ônibus da cidade',
    latitude: -23.5505,
    longitude: -46.6333,
    address: 'Praça da Sé, 100 - Centro',
    createdAt: new Date('2024-01-15')
  },
  {
    id: '2',
    name: 'Shopping Center',
    description: 'Parada em frente ao shopping principal',
    latitude: -23.5489,
    longitude: -46.6388,
    address: 'Av. Paulista, 1500',
    createdAt: new Date('2024-01-16')
  },
  {
    id: '3',
    name: 'Universidade',
    description: 'Campus principal da universidade',
    latitude: -23.5558,
    longitude: -46.6396,
    address: 'Rua Universitária, 300',
    createdAt: new Date('2024-01-17')
  }
];

export const mockBusLines: BusLine[] = [
  {
    id: '1',
    name: 'Centro-Bairro',
    number: '101',
    description: 'Liga o centro aos bairros residenciais',
    color: '#3b82f6',
    createdAt: new Date('2024-01-10')
  },
  {
    id: '2',
    name: 'Circular Shopping',
    number: '202',
    description: 'Linha circular passando pelos principais shoppings',
    color: '#10b981',
    createdAt: new Date('2024-01-11')
  }
];

export const mockVehicles: Vehicle[] = [
  {
    id: '1',
    plateNumber: 'ABC-1234',
    model: 'Mercedes-Benz OF-1721',
    capacity: 80,
    busLineId: '1',
    busLine: mockBusLines[0],
    createdAt: new Date('2024-01-20')
  },
  {
    id: '2',
    plateNumber: 'DEF-5678',
    model: 'Volvo B270F',
    capacity: 70,
    busLineId: '1',
    busLine: mockBusLines[0],
    createdAt: new Date('2024-01-21')
  },
  {
    id: '3',
    plateNumber: 'GHI-9012',
    model: 'Scania K270IB',
    capacity: 85,
    busLineId: '2',
    busLine: mockBusLines[1],
    createdAt: new Date('2024-01-22')
  }
];

export const mockRoutes: Route[] = [
  {
    id: '1',
    busLineId: '1',
    busLine: mockBusLines[0],
    busStops: [mockBusStops[0], mockBusStops[2]],
    direction: 'outbound',
    estimatedDuration: 45
  },
  {
    id: '2',
    busLineId: '2',
    busLine: mockBusLines[1],
    busStops: [mockBusStops[0], mockBusStops[1], mockBusStops[2]],
    direction: 'outbound',
    estimatedDuration: 60
  }
];
