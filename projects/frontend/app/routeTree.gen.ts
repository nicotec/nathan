import { Route as rootRoute } from './routes/__root'
import { Route as IndexRoute } from './routes/index'
import { createRouteTree } from '@tanstack/react-router'

const routeTree = rootRoute.addChildren([IndexRoute])

export { routeTree }