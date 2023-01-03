import React, {Component, useEffect, useRef, useState} from 'react';
import * as d3 from 'd3';
import { Graph1DataCollection } from '../../types/Graph1DataCollection';
import { Graph1Data } from '../../types/Graph1Data';

const LineChart = () => {
    const [data, setData] = useState<Graph1Data[]>([]);
    var margin = { top: 20, right: 20, bottom: 50, left: 70 },
        width = 960 - margin.left - margin.right,
        height = 500 - margin.top - margin.bottom;


    useEffect(() => {
        fetch('/graph1_datas')
          .then((res) => res.json())
          .then((data: Graph1DataCollection) => {
            var formatter = d3.timeParse("%d-%m-%Y");
            const array = data['hydra:member'];
            array.forEach(function(d,i) {
                d.datetime = formatter(d.datetime);
            });
            setData(array)
          })
      }, [])

   
    React.useEffect(() => {
        var svg = d3.select("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
        .attr("transform", `translate(${margin.left},     ${margin.top})`);

        var x = d3.scaleTime().range([0, width]);
        var y = d3.scaleLinear().range([height, 0]);
        x.domain(d3.extent(data, (d: Graph1Data) => { return d.datetime; }));
        y.domain([0, d3.max(data, (d: Graph1Data) => { return d.value; })]);

        svg.append("g")
        .attr("transform", `translate(0, ${height})`)
        .call(d3.axisBottom(x));
        svg.append("g")
        .call(d3.axisLeft(y));

        var valueLine = d3.line()
                   .x((d: Graph1Data) => { return x(d.datetime); })
                   .y((d: Graph1Data) => { return y(d.value); });

        svg.append("path")
        .data([data])
        .attr("class", "line")
        .attr("fill", "none")
        .attr("stroke", "black")
        .attr("stroke-width", 1.5)
        .attr("d", valueLine)

    }, [data]);
   
    return <svg />;
  };
   
  export default LineChart;