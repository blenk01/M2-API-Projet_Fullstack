import React, {Component, useEffect, useRef, useState} from 'react';
import * as d3 from 'd3';
import { Graph2DataCollection } from '../../types/Graph2DataCollection';
import { Graph2Data } from '../../types/Graph2Data';
import { Graph1Data } from '../../types/Graph1Data';

const BarChart = () => {
    const [data, setData] = useState<Graph2Data[]>([]);
    const [startAt, setStartAt] = useState<Date>(new Date());
    const [endAt, setEndAt] = useState<Date>(new Date);

    const loadData = () => {
        const startAtFormatted = startAt.getDate() 
            + "-" 
            + (startAt.getMonth() + 1)
            + "-" 
            + startAt.getFullYear();

        const endAtFormatted = endAt.getDate() 
            + "-" 
            + endAt.getMonth()
            + "-" 
            + endAt.getFullYear();
        
        fetch(`/graph2_datas?startAt=${startAtFormatted}&endAt=${endAtFormatted}`)
          .then((res) => res.json())
          .then((data: Graph2DataCollection) => {
            var formatter = d3.timeParse("%d-%m-%Y");
            const array = data['hydra:member'];
            array.forEach(function(d,i) {
                d.datetime = formatter(d.datetime);
            });
            setData(array)
          })
    }

    useEffect(() => {
        loadData();
    }, []);

    useEffect(() => {
        loadData();
    }, [endAt, startAt]);

    const margin = { top: 10, right: 0, bottom: 20, left: 100 };
    const width = 1000 - margin.left - margin.right;
    const height = 300 - margin.top - margin.bottom;

    useEffect(() => {
        d3.select("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)

        const g = d3.select("#gContainer");
        g.selectAll("rect").remove()
        g.attr("transform", `translate(${margin.left},     ${margin.top})`);

        var scaleX = d3.scaleTime().range([0, width]);
        var scaleY = d3.scaleLinear().range([height, 0]);

        scaleX.domain(d3.extent(data, (d: Graph1Data) => { return d.datetime; }));
        scaleY.domain([0, d3.max(data, (d: Graph2Data) => { return d.nbVente; })]);
        
        d3.select("#gAxisBottom")
        .attr("transform", `translate(0, ${height})`)
        .call(d3.axisBottom(scaleX));
        d3.select("#gAxisLeft")
        .call(d3.axisLeft(scaleY));
        
        data.forEach((d: Graph2Data) => {
            g.append("rect")
            .attr('x', scaleX(d.datetime))
            .attr('y', scaleY(d.nbVente))
            .attr('width', '10')
            .attr('height', height - scaleY(d.nbVente))
            .attr('fill', 'teal')
        });
        
    }, [data])
   
    return (
        <div>
            <input type={"date"} onChange={(e) => setStartAt(new Date(e.target.value))} />
            <input type={"date"} onChange={(e) => setEndAt(new Date(e.target.value))} />
            <svg
                width={width + margin.left + margin.right}
                height={height + margin.top + margin.bottom}
            >
                <g id="gContainer">
                    <g id="gAxisBottom"></g>
                    <g id="gAxisLeft"></g>
                </g>
            </svg>
        </div>
    );
  };
   
  export default BarChart;