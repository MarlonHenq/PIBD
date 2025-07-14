
export interface BusStop {
  id: string;
  name: string;
  description?: string;
  latitude: number;
  longitude: number;
  address: string;
  createdAt: Date;
}

export interface BusLine {
  id: string;
  name: string;
  number: string;
  description?: string;
  color: string;
  createdAt: Date;
}

export interface Vehicle {
  id: string;
  plateNumber: string;
  model: string;
  capacity: number;
  busLineId: string;
  busLine?: BusLine;
  createdAt: Date;
}

export interface Route {
  id: string;
  busLineId: string;
  busLine?: BusLine;
  busStops: BusStop[];
  direction: 'outbound' | 'return';
  estimatedDuration: number; // em minutos
}
