import networkx as nx

with open("input") as f:
    content = f.readlines()
LINES = [x.strip() for x in content]

# Create a graph of programs
graph = nx.Graph()

for line in LINES:
    # Parse the line
    node, neighbors = line.split(' <-> ')

    # Add edges defined by this line
    graph.add_edges_from((node, neighbor) for neighbor in neighbors.split(', '))

print('Part 1:', len(nx.node_connected_component(graph, '0')))
print('Part 2:', nx.number_connected_components(graph))

